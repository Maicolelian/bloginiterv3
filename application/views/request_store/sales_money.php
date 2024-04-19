
<script src="<?php echo base_url() ?>assets/js/store/loader.js"></script>

<script type="text/javascript">
    google.charts.load("current", {packages: ['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Día", "Ventas"],

<?php foreach ($total as $key => $t) : ?>
                ["<?php echo $t->date ?>", <?php echo $t->total ?>],
<?php endforeach; ?>

        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"}]);

        var options = {
            title: "Ventas",
            width: 900,
            height: 400,
            bar: {groupWidth: "90%"},
            legend: {position: "none"},
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
        chart.draw(view, options);
    }

</script>

<form class="form-inline" id="form-filter">
    <a href="<?php echo base_url() ?>request_store/sales_money" class="btn btn-default"><i class="fa fa-filter"></i></a>
    <input name="begin" type="date" placeholder="Fecha inicial" value="<?php echo $begin ?>" class="form-control">
    <input name="end" type="date" placeholder="Fecha final" value="<?php echo $end ?>" class="form-control">
    <input name="count" type="number" min="0" placeholder="Cantidad"  value="<?php echo $count ?>" class="form-control">
    <button type="submit" class="btn btn-success">Enviar</button>
</form>

<div id="chart_div"></div>

<script>

    document.querySelector("#form-filter")
            .addEventListener('submit', function (event) {


                if (
                        (document.querySelector("[name=begin]").value != ""
                                &&
                                document.querySelector("[name=end]").value == "") || 
                                (document.querySelector("[name=end]").value != "" 
                                && 
                                document.querySelector("[name=begin]").value == "")) {
                    event.preventDefault()
                    alert("Debe de seleccionar ambas fechas")
                }

            })

    document.querySelector("[name=begin]").addEventListener('change', changeBeginTime)

    function changeBeginTime(e) {
        begin = new Date(e.target.value);
        begin.setDate(begin.getDate() + 2);

        date = begin.getDate();
        if (date <= 9) {
            date = "0" + date;
        }

        month = begin.getMonth() + 1;
        if (month <= 9) {
            month = "0" + month;
        }

        format = begin.getFullYear() + "-" + month + "-" + date;

        document.querySelector("[name=end]").value = "";
        document.querySelector("[name=end]").min = format;

    }

</script>