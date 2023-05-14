var xValues = ["BS-IT", "BS-CS", "BS-CE", "BS-IS", ];
var yValues = [300, 350, 200, 150, 100];
var barColors = ["red", "green","blue","orange","brown"];

new Chart("myChart", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Enrolled CCS Students As of S.Y 2023"
    }
  }
});
