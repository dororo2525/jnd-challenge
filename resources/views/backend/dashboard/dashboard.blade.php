@extends('layouts.app')
@section('title')
    Dashboard
@endsection
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.41.0/apexcharts.min.css" integrity="sha512-5k2n0KtbytaKmxjJVf3we8oDR34XEaWP2pibUtul47dDvz+BGAhoktxn7SJRQCHNT5aJXlxzVd45BxMDlCgtcA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <style>
    #chart {
  max-width: 650px;
  margin: 35px auto;
}

 </style>
@endsection
@section('content')
    <section class="content">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-5">
                              <div class="input-group">
                                <label for="startDate" class="input-group-text">Start Date</label>
                                <input type="date" class="form-control" id="startDate" required>
                              </div>
                            </div>
                            <div class="col-lg-5">
                              <div class="input-group">
                                <label for="endDate" class="input-group-text">End Date</label>
                                <input type="date" class="form-control" id="endDate" required>
                              </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary" id="btn-search" type="button">Search</button>
                                  </div>
                            </div>
                          </div>
            </div>
        </div>
        </div>
        <div class="col-md-12 mt-3" id="loading">
            <div class="text-center">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
        </div>
        <div class="row" id="chart-data"></div>

    </section>
@endsection
@section('script')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.js" integrity="sha512-mlz/Fs1VtBou2TrUkGzX4VoGvybkD9nkeXWJm3rle0DPHssYYx4j+8kIS15T78ttGfmOjH0lLaBXGcShaVkdkg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.3.0/chart.umd.js" integrity="sha512-CMF3tQtjOoOJoOKlsS7/2loJlkyctwzSoDK/S40iAB+MqWSaf50uObGQSk5Ny/gfRhRCjNLvoxuCvdnERU4WGg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.41.0/apexcharts.min.js" integrity="sha512-bp/xZXR0Wn5q5TgPtz7EbgZlRrIU3tsqoROPe9sLwdY6Z+0p6XRzr7/JzqQUfTSD3rWanL6WUVW7peD4zSY/vQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
var month = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]
var emptyData = [0,0,0,0,0,0,0,0,0,0,0,0];
    $.ajax({
        type: "get",
        url: "{{ url('get-chart-data') }}",
        dataType: "json",
        success: function (response) {
          if(response.length == 0){
                $('#loading').html(`<div class="col-md-12 text-center"><h3>No Data Found</h3></div>`);
                return false;
            }
            var data = ``;
            $.each(response, function (indexInArray, valueOfElement) { 
                data += `
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5>${valueOfElement.shorten_url}</h5>
                        </div>
                        <div class="card-body">
                            <div id="chart-${valueOfElement.code}">
                            </div>
                        </div>
                    </div>
                </div>
                `;
            });
            $('#chart-data').html(data);
            $('#loading').hide();
            $.each(response, function (indexInArray, valueOfElement) { 
                var currentMonth = []
                var currenValue = []
                $.each(valueOfElement.clicks, function (indexInArray, valueOfElement) {
                    currenValue.push(valueOfElement);
                    currentMonth.push(month[indexInArray]);
                });
                console.log(currentMonth);
                var options = {
                    series: [{
                    name: 'Clicks',
                    data: currenValue.length > 0 ? currenValue : emptyData
                  }],
                    chart: {
                    height: 350,
                    type: 'bar',
                  },
                  plotOptions: {
                    bar: {
                      borderRadius: 10,
                      dataLabels: {
                        position: 'top', // top, center, bottom
                      },
                    }
                  },
                  dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                      return val;
                    },
                    offsetY: -20,
                    style: {
                      fontSize: '12px',
                      colors: ["#304758"]
                    }
                  },
                  
                  xaxis: {
                    categories: currentMonth.length > 0 ? currentMonth : month,
                    position: 'top',
                    axisBorder: {
                      show: false
                    },
                    axisTicks: {
                      show: false
                    },
                    crosshairs: {
                      fill: {
                        type: 'gradient',
                        gradient: {
                          colorFrom: '#D8E3F0',
                          colorTo: '#BED1E6',
                          stops: [0, 100],
                          opacityFrom: 0.4,
                          opacityTo: 0.5,
                        }
                      }
                    },
                    tooltip: {
                      enabled: true,
                    }
                  },
                  yaxis: {
                    axisBorder: {
                      show: false
                    },
                    axisTicks: {
                      show: false,
                    },
                    labels: {
                      show: false,
                      formatter: function (val) {
                        return val + "Clicks";
                      }
                    }
                  
                  },
                  title: {
                    text: 'Shorten Url Clicks in Current Year',
                    floating: true,
                    offsetY: 330,
                    align: 'center',
                    style: {
                      color: '#444'
                    }
                  }
                  };
            
                  var chart = new ApexCharts(document.querySelector(`#chart-${valueOfElement.code}`), options);
                  chart.render();
            });
        }
    });
   
   $('#btn-search').click(function() {
       $('#loading').show();
       var startDate = $('#startDate').val();
       var endDate = $('#endDate').val();
       $.ajax({
           type: "post",
           url: "{{ route('dashboard.post-chart-data') }}",
           data: {
               startDate: startDate,
               endDate: endDate,
                _token: "{{ csrf_token() }}"
           },
           dataType: "json",
           success: function (response) {
            if(response.length == 0){
                $('#loading').html(`<div class="col-md-12 text-center"><h3>No Data Found</h3></div>`);
                return false;
            }
               var data = ``;
            $.each(response, function (indexInArray, valueOfElement) { 
                data += `
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5>${valueOfElement.shorten_url}</h5>
                        </div>
                        <div class="card-body">
                            <div id="chart-${valueOfElement.code}">
                            </div>
                        </div>
                    </div>
                </div>
                `;
            });
            $('#chart-data').html(data);
            $('#loading').hide();
            $.each(response, function (indexInArray, valueOfElement) { 
                var currentMonth = []
                var currenValue = []
                $.each(valueOfElement.clicks, function (indexInArray, valueOfElement) {
                    var splitMonth = indexInArray.split('-');
                    currenValue.push(valueOfElement);
                    currentMonth.push(month[splitMonth[1]-1]);
                });
                var options = {
                    series: [{
                    name: 'Clicks',
                    data: currenValue.length > 0 ? currenValue : emptyData
                  }],
                    chart: {
                    height: 350,
                    type: 'bar',
                  },
                  plotOptions: {
                    bar: {
                      borderRadius: 10,
                      dataLabels: {
                        position: 'top', // top, center, bottom
                      },
                    }
                  },
                  dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                      return val;
                    },
                    offsetY: -20,
                    style: {
                      fontSize: '12px',
                      colors: ["#304758"]
                    }
                  },
                  
                  xaxis: {
                    categories: currentMonth.length > 0 ? currentMonth : month,
                    position: 'top',
                    axisBorder: {
                      show: false
                    },
                    axisTicks: {
                      show: false
                    },
                    crosshairs: {
                      fill: {
                        type: 'gradient',
                        gradient: {
                          colorFrom: '#D8E3F0',
                          colorTo: '#BED1E6',
                          stops: [0, 100],
                          opacityFrom: 0.4,
                          opacityTo: 0.5,
                        }
                      }
                    },
                    tooltip: {
                      enabled: true,
                    }
                  },
                  yaxis: {
                    axisBorder: {
                      show: false
                    },
                    axisTicks: {
                      show: false,
                    },
                    labels: {
                      show: false,
                      formatter: function (val) {
                        return val + "Clicks";
                      }
                    }
                  
                  },
                  title: {
                    text: startDate + ' to ' + endDate,
                    floating: true,
                    offsetY: 330,
                    align: 'center',
                    style: {
                      color: '#444'
                    }
                  }
                  };
            
                  var chart = new ApexCharts(document.querySelector(`#chart-${valueOfElement.code}`), options);
                  chart.render();
            });
           }
       });
   }
    );
</script>
@endsection
