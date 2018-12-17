google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart(){
  $("#message-container .message-body").empty();
  $("#stock-symbol-search-form-container").show();
};


$("#stock-symbol-search-form").on("submit",function(event){

  event.preventDefault();

  var formElementsValues =  $(this).serialize();

  var requestStockInfo = $.ajax({
    url: "/service/stock-data/info",
    method: "GET",
    data: formElementsValues,
    dataType:"json"
  });

  var requestStockPrices = $.ajax({
    url: "/service/stock-data/prices",
    method: "GET",
    data: formElementsValues,
    dataType:"json"
  });

  requestStockInfo.done(function(data,textStatus,jqXHR){
     $("#stock-info-symbol").text(data.symbol);
     $("#stock-info-name").text(data.name);
  });

  requestStockPrices.done(function(data,textStatus,jqXHR){

    var dataTable = new google.visualization.DataTable(jqXHR.responseText);

    var options = {
      legend:'none',
      hAxis: {
        format: 'dd/MM',
      }
    };

    var chart = new google.visualization.CandlestickChart(document.getElementById('stock-chart'));
    chart.draw(dataTable, options);

  });

});
