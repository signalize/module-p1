import {Widget} from "/js/widget.js";
import {Collection} from "/js/database.js";
import "/js/chart.js";

customElements.define('module-p1', class extends Widget {
    static service = 'service-module-p1';

    static chart;

    initiate(){
        this.innerHTML = '<canvas id="module-p1-chart"></canvas>';
        let element = document.getElementById('module-p1-chart');
        this.chart = new Chart(element, {
            "type":"line",
            data: {
                labels: [new Date("2015-3-15 13:3").toLocaleString(), new Date("2015-3-25 13:2").toLocaleString(), new Date("2015-4-25 14:12").toLocaleString()],
                datasets: [{
                    label: 'Energy (low)',
                    data: [],
                    fill: false,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                    {
                        label: 'Energy (high)',
                        data: [],
                        fill: false,
                        borderColor: 'rgba(255,99,132,1)',
                        borderWidth: 1
                    }]
            },
            options: {
                animation: false
            }
        });
    }

    /**
     * @param {Collection} data
     */
    update(data) {
        let dataset = [];
        data.forEach(point => {
            let date = new Date(point['datetime'] * 1000);
            if(date == "Invalid Date"){
                return;
            }
            let hr = ("0"+date.getHours()).substr(-2);
            let min = ("0"+(5 * Math.round(date.getMinutes() / 5))).substr(-2);

            if(!dataset[hr+"_"+min]){
                dataset[hr+"_"+min] = {
                    low: {
                        start: point['energy.usage.low'],
                        end: point['energy.usage.low']
                    },
                    high: {
                        start: point['energy.usage.high'],
                        end: point['energy.usage.high']
                    }
                };
            } else {
                if(point['energy.usage.low'] > dataset[hr+"_"+min].low.end){
                    dataset[hr+"_"+min].low.end = point['energy.usage.low'];
                }
                if(point['energy.usage.high'] > dataset[hr+"_"+min].high.end){
                    dataset[hr+"_"+min].high.end = point['energy.usage.high'];
                }
            }
        });

        let ordered = {};
        Object.keys(dataset).sort().forEach(key => {
            ordered[key] = dataset[key];
        });


        this.chart.data.labels = Object.keys(ordered).map((k) => {
            let date = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate(), k.split("_")[0], k.split("_")[1]);
            return ("0" + date.getHours()).substr(-2) +":"+ ("0" + date.getMinutes()).substr(-2);
        });

        this.chart.data.datasets[0].data = Object.keys(ordered).map((k) => {
            return (dataset[k].low.end - dataset[k].low.start) * 1000;
        });

        this.chart.data.datasets[1].data = Object.keys(ordered).map((k) => {
            return (dataset[k].high.end - dataset[k].high.start) * 1000;
        });
        this.chart.update();
        
        /*
           return Widget.parse`
           <h1>Electricity</h1>

           <h2>Usage</h2>
           ${data ? `
               <div>${data['energy.usage.low']}</div>
               <div>${data['energy.usage.high']}</div>
               <h2>Result</h2>
               <div>${data['energy.result.low']}</div>
               <div>${data['energy.result.high']}</div>
           ` : `
               Loading...
           `}

           <h1>Gas</h1>
           ${data ? `
               <div>Amount: ${data['gas.usage.total']}</div>
           ` : `
               Loading...
           `}
           `;
   */
    }

});