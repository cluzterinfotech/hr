    var prefs = new _IG_Prefs();
    var gadgetHelper;

    _IG_RegisterOnloadHandler(loadVisualizationAPI);

    function loadVisualizationAPI() {
      google.load('visualization', '1', {packages: ['orgchart']});
      google.setOnLoadCallback(initialize);
    };

    function initialize() {
      var title = prefs.getString('title');
      if (title) {
        _IG_SetTitle(title);
      }
      gadgetHelper = new google.visualization.GadgetHelper();
      var query = gadgetHelper.createQueryFromPrefs(prefs);
      query.send(responseHandler);
    };

    function responseHandler(response) {
      var loadingMsgContainer = document.getElementById('loading');
      if (loadingMsgContainer) {
        loadingMsgContainer.style.display = 'none';
      }
      if (!gadgetHelper.validateResponse(response)) {
        // Default error handling was done, just leave.
        return;
      }
      
      var container = document.getElementById('chart');
      container.style.width = document.body.clientWidth + 'px';
      container.style.height = document.body.clientHeight + 'px';
      var visualizationObject =
          new google.visualization.OrgChart(container);

      var dataTable = response.getDataTable();
      var options = null;
      visualizationObject.draw(dataTable, options);
    };