$(document).ready(function () {
  google.charts.load("current", { packages: ["line"] }).then(function () {
    function carga() {
      $.ajax({
        url: "Backend/components/obtenerData",
        type: "GET",
        success: function (response) {
          change_day(response);
          google.charts.setOnLoadCallback(drawChart(response));
        },
        contentType: "application/json; charset=utf-8",
        dataType: "json",
      });
    }

    carga();
    setInterval(carga, 10000);

    function drawChart(result) {
      var data = new google.visualization.DataTable();
      data.addColumn("timeofday", "Hora");
      data.addColumn("number", "Costo Bitcoin");

      // Iterando sobre el response de la consulta al back
      let datos = []; //Array de renderizado
      $.each(result, function (i, obj) {
        // Formateando hora
        var dateTime = i.split(" ");
        var hora = dateTime[1].split(":");

        // Agregando elementos a array de renderizado
        datos.push([
          [parseInt(hora[0]) + 1, parseInt(hora[1]), parseInt(hora[2])],
          parseInt(obj),
        ]);
      });

      data.addRows(datos);

      var options = {
        chart: {
          title: "Fluctuación precio del Bitcoin",
          subtitle: "en pesos Mexicanos (MXN)",
        },
        width: 1000,
        height: 600,
      };

      var chart = new google.charts.Line(
        document.getElementById("curve_chart")
      );

      chart.draw(data, google.charts.Line.convertOptions(options));
    }
  });
});

function change_day(data) {
  if ($("#watcher").length === 0) {
    moment.locale("es");
    var dateToday = "";
    $.each(data, function (key, value) {
      dateToday = key;
      return false;
    });

    var fechaFormateada = moment(dateToday).format("D [de] MMMM");
    console.log(fechaFormateada);
    $("#day_today").text(fechaFormateada);
    $("body").append('<div id="watcher"></div>');
  }
}
