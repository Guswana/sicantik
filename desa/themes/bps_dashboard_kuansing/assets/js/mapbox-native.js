(function (window, document) {
  "use strict";

  if (!window.mapboxgl) {
    return;
  }

  var OPENSTREETMAP_ATTRIBUTION =
    '<a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener noreferrer">&copy; OpenStreetMap</a>';
  var OPENSID_ATTRIBUTION =
    '<a href="https://github.com/OpenSID/OpenSID" target="_blank" rel="noopener noreferrer">OpenSID</a>';

  function toNumber(value, fallback) {
    var parsed = Number(value);

    return isFinite(parsed) ? parsed : fallback;
  }

  function toLngLat(lat, lng) {
    return [toNumber(lng, 0), toNumber(lat, 0)];
  }

  function buildRasterStyle(sourceId, tiles, attribution) {
    var style = {
      version: 8,
      sources: {},
      layers: [],
    };

    style.sources[sourceId] = {
      type: "raster",
      tiles: tiles,
      tileSize: 256,
      attribution: attribution,
    };

    style.layers.push({
      id: sourceId + "-layer",
      type: "raster",
      source: sourceId,
    });

    return style;
  }

  function getStyleCatalog(accessToken) {
    var styles = [
      {
        id: "1",
        label: "OpenStreetMap",
        style: buildRasterStyle(
          "bps-osm",
          ["https://tile.openstreetmap.org/{z}/{x}/{y}.png"],
          OPENSTREETMAP_ATTRIBUTION
        ),
      },
      {
        id: "2",
        label: "OpenStreetMap H.O.T.",
        style: buildRasterStyle(
          "bps-osm-hot",
          [
            "https://a.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png",
            "https://b.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png",
            "https://c.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png",
          ],
          OPENSTREETMAP_ATTRIBUTION
        ),
      },
    ];

    if (accessToken) {
      styles.push(
        {
          id: "3",
          label: "Mapbox Streets",
          style: "mapbox://styles/mapbox/streets-v11",
        },
        {
          id: "4",
          label: "Mapbox Satellite",
          style: "mapbox://styles/mapbox/satellite-v9",
        },
        {
          id: "5",
          label: "Mapbox Satellite-Street",
          style: "mapbox://styles/mapbox/satellite-streets-v11",
        }
      );
    }

    return styles;
  }

  function getStyleById(styleCatalog, styleId) {
    for (var i = 0; i < styleCatalog.length; i += 1) {
      if (styleCatalog[i].id === styleId) {
        return styleCatalog[i];
      }
    }

    return styleCatalog[0];
  }

  function resolveInitialStyleId(accessToken, styleId) {
    var normalizedStyleId = String(styleId || "");
    var styleCatalog = getStyleCatalog(accessToken);

    for (var i = 0; i < styleCatalog.length; i += 1) {
      if (styleCatalog[i].id === normalizedStyleId) {
        return normalizedStyleId;
      }
    }

    return accessToken ? "5" : "1";
  }

  function createStyleSwitcherControl(styleCatalog, state) {
    function StyleSwitcherControl() {}

    StyleSwitcherControl.prototype.onAdd = function (map) {
      var container = document.createElement("div");
      var toggleButton = document.createElement("button");
      var panel = document.createElement("div");
      var self = this;

      this._map = map;
      this._container = container;
      this._documentClickHandler = function (event) {
        if (!container.contains(event.target)) {
          container.classList.remove("is-open");
        }
      };

      container.className =
        "mapboxgl-ctrl mapboxgl-ctrl-group bps-mapbox-style-switcher";

      toggleButton.type = "button";
      toggleButton.className = "bps-mapbox-style-switcher__toggle";
      toggleButton.setAttribute("aria-label", "Pilih jenis peta");
      toggleButton.innerHTML = '<i class="fas fa-layer-group" aria-hidden="true"></i>';
      toggleButton.addEventListener("click", function (event) {
        event.preventDefault();
        event.stopPropagation();
        container.classList.toggle("is-open");
      });

      panel.className = "bps-mapbox-style-switcher__panel";

      for (var i = 0; i < styleCatalog.length; i += 1) {
        (function (styleItem) {
          var option = document.createElement("label");
          var input = document.createElement("input");
          var text = document.createElement("span");

          option.className = "bps-mapbox-style-switcher__option";

          input.type = "radio";
          input.name = "bps-mapbox-style-" + state.instanceId;
          input.value = styleItem.id;
          input.checked = styleItem.id === state.currentStyleId;
          input.addEventListener("change", function () {
            if (!input.checked || state.currentStyleId === styleItem.id) {
              return;
            }

            state.currentStyleId = styleItem.id;
            container.classList.remove("is-open");
            self._map.setStyle(styleItem.style);
          });

          text.textContent = styleItem.label;

          option.appendChild(input);
          option.appendChild(text);
          panel.appendChild(option);
        })(styleCatalog[i]);
      }

      container.addEventListener("mousedown", function (event) {
        event.stopPropagation();
      });
      container.addEventListener("touchstart", function (event) {
        event.stopPropagation();
      });

      document.addEventListener("click", this._documentClickHandler);

      container.appendChild(toggleButton);
      container.appendChild(panel);

      return container;
    };

    StyleSwitcherControl.prototype.onRemove = function () {
      if (this._container && this._container.parentNode) {
        this._container.parentNode.removeChild(this._container);
      }

      if (this._documentClickHandler) {
        document.removeEventListener("click", this._documentClickHandler);
      }

      this._map = undefined;
    };

    return new StyleSwitcherControl();
  }

  function createMap(options) {
    var accessToken = String(options.accessToken || "").trim();
    var styleCatalog = getStyleCatalog(accessToken);
    var currentStyleId = resolveInitialStyleId(accessToken, options.styleId);
    var currentStyle = getStyleById(styleCatalog, currentStyleId);
    var state = {
      currentStyleId: currentStyleId,
      instanceId: Date.now() + "-" + Math.round(Math.random() * 100000),
    };

    if (accessToken) {
      mapboxgl.accessToken = accessToken;
    }

    var map = new mapboxgl.Map({
      container: options.container,
      style: currentStyle.style,
      center: options.center,
      zoom: toNumber(options.zoom, 10),
      minZoom: toNumber(options.minZoom, 1),
      maxZoom: toNumber(options.maxZoom, 22),
      attributionControl: false,
    });

    map.addControl(
      new mapboxgl.AttributionControl({
        compact: true,
        customAttribution: OPENSID_ATTRIBUTION,
      })
    );

    if (options.showNavigation !== false) {
      map.addControl(
        new mapboxgl.NavigationControl(),
        options.navigationPosition || "top-left"
      );
    }

    if (options.showScale) {
      map.addControl(
        new mapboxgl.ScaleControl({ maxWidth: 100, unit: "metric" }),
        options.scalePosition || "bottom-left"
      );
    }

    if (options.showStyleSwitcher !== false && styleCatalog.length > 1) {
      map.addControl(
        createStyleSwitcherControl(styleCatalog, state),
        options.styleControlPosition || "top-right"
      );
    }

    if (typeof options.onLoad === "function") {
      map.once("load", function () {
        options.onLoad(map);
      });
    }

    if (typeof options.onStyleLoad === "function") {
      map.on("style.load", function () {
        options.onStyleLoad(map);
      });
    }

    return map;
  }

  function createPopup(popupHtml, options) {
    return new mapboxgl.Popup({
      closeButton: options && options.closeButton !== undefined ? options.closeButton : true,
      closeOnClick:
        options && options.closeOnClick !== undefined ? options.closeOnClick : true,
      offset: options && options.offset ? options.offset : 20,
      maxWidth: options && options.maxWidth ? options.maxWidth : "320px",
    }).setHTML(popupHtml);
  }

  function addMarker(map, options) {
    var markerOptions = {};

    if (options.element) {
      markerOptions.element = options.element;
    }

    if (options.color) {
      markerOptions.color = options.color;
    }

    if (options.offset) {
      markerOptions.offset = options.offset;
    }

    var marker = new mapboxgl.Marker(markerOptions)
      .setLngLat(options.lngLat)
      .addTo(map);

    if (options.popupHtml) {
      marker.setPopup(createPopup(options.popupHtml, options.popupOptions || {}));
    }

    return marker;
  }

  function createImageMarkerElement(iconUrl, className) {
    var element = document.createElement("div");

    element.className = "bps-mapbox-marker" + (className ? " " + className : "");
    element.style.backgroundImage = 'url("' + iconUrl + '")';

    return element;
  }

  function convertLatLngPath(path) {
    if (!Array.isArray(path)) {
      return path;
    }

    if (
      path.length >= 2 &&
      typeof path[0] === "number" &&
      typeof path[1] === "number"
    ) {
      return [toNumber(path[1], 0), toNumber(path[0], 0)];
    }

    var converted = [];

    for (var i = 0; i < path.length; i += 1) {
      converted.push(convertLatLngPath(path[i]));
    }

    return converted;
  }

  function getArrayDepth(value) {
    var depth = 0;
    var current = value;

    while (Array.isArray(current)) {
      depth += 1;
      current = current[0];
    }

    return depth;
  }

  function closeRing(ring) {
    if (!ring || !ring.length) {
      return ring;
    }

    var closedRing = ring.slice();
    var first = ring[0];
    var last = ring[ring.length - 1];

    if (!last || first[0] !== last[0] || first[1] !== last[1]) {
      closedRing.push([first[0], first[1]]);
    }

    return closedRing;
  }

  function latLngPathToFeature(path, properties) {
    var converted = convertLatLngPath(path);
    var depth = getArrayDepth(converted);
    var geometry = null;

    if (depth === 2) {
      geometry = {
        type: "Polygon",
        coordinates: [closeRing(converted)],
      };
    } else if (depth === 3) {
      geometry = {
        type: "Polygon",
        coordinates: converted.map(closeRing),
      };
    } else if (depth === 4) {
      geometry = {
        type: "MultiPolygon",
        coordinates: converted.map(function (polygon) {
          return polygon.map(closeRing);
        }),
      };
    }

    if (!geometry) {
      return null;
    }

    return {
      type: "Feature",
      properties: properties || {},
      geometry: geometry,
    };
  }

  function bindLayerPopup(map, layerId, popupHtml) {
    if (!popupHtml) {
      return;
    }

    if (!map.__bpsLayerPopupBindings) {
      map.__bpsLayerPopupBindings = {};
    }

    if (map.__bpsLayerPopupBindings[layerId]) {
      return;
    }

    map.__bpsLayerPopupBindings[layerId] = true;

    map.on("mouseenter", layerId, function () {
      map.getCanvas().style.cursor = "pointer";
    });

    map.on("mouseleave", layerId, function () {
      map.getCanvas().style.cursor = "";
    });

    map.on("click", layerId, function (event) {
      createPopup(popupHtml, { maxWidth: "220px" })
        .setLngLat(event.lngLat)
        .addTo(map);
    });
  }

  function renderPolygon(map, options) {
    var feature = latLngPathToFeature(options.path, options.properties);
    var sourceId = options.sourceId || "bps-polygon";
    var fillLayerId = options.fillLayerId || sourceId + "-fill";
    var lineLayerId = options.lineLayerId || sourceId + "-line";
    var featureCollection;

    if (!feature) {
      return null;
    }

    featureCollection = {
      type: "FeatureCollection",
      features: [feature],
    };

    if (map.getSource(sourceId)) {
      map.getSource(sourceId).setData(featureCollection);
    } else {
      map.addSource(sourceId, {
        type: "geojson",
        data: featureCollection,
      });
    }

    if (!map.getLayer(fillLayerId)) {
      map.addLayer({
        id: fillLayerId,
        type: "fill",
        source: sourceId,
        paint: {
          "fill-color": options.fillColor || "#8888dd",
          "fill-opacity": toNumber(options.fillOpacity, 0.5),
        },
      });
    }

    if (!map.getLayer(lineLayerId)) {
      map.addLayer({
        id: lineLayerId,
        type: "line",
        source: sourceId,
        paint: {
          "line-color": options.lineColor || "#FF0000",
          "line-width": toNumber(options.lineWidth, 2),
          "line-opacity": toNumber(options.lineOpacity, 1),
        },
      });
    }

    bindLayerPopup(map, fillLayerId, options.popupHtml);

    return feature;
  }

  function getBoundsFromFeature(feature) {
    if (!feature || !feature.geometry || !feature.geometry.coordinates) {
      return null;
    }

    var bounds = new mapboxgl.LngLatBounds();
    var hasCoordinates = false;

    function visitCoordinates(value) {
      if (!Array.isArray(value)) {
        return;
      }

      if (
        value.length >= 2 &&
        typeof value[0] === "number" &&
        typeof value[1] === "number"
      ) {
        bounds.extend(value);
        hasCoordinates = true;

        return;
      }

      for (var i = 0; i < value.length; i += 1) {
        visitCoordinates(value[i]);
      }
    }

    visitCoordinates(feature.geometry.coordinates);

    return hasCoordinates ? bounds : null;
  }

  function fitFeatureBounds(map, feature, options) {
    var bounds = getBoundsFromFeature(feature);

    if (!bounds) {
      return;
    }

    map.fitBounds(bounds, {
      padding: options && options.padding ? options.padding : 24,
      duration: options && options.duration !== undefined ? options.duration : 0,
    });
  }

  window.BpsDashboardKuansingMapbox = {
    addMarker: addMarker,
    createImageMarkerElement: createImageMarkerElement,
    createMap: createMap,
    fitFeatureBounds: fitFeatureBounds,
    latLngPathToFeature: latLngPathToFeature,
    renderPolygon: renderPolygon,
    resolveInitialStyleId: resolveInitialStyleId,
    toLngLat: toLngLat,
  };
})(window, document);
