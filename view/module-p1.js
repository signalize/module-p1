import {Widget} from "/js/widget.js";

customElements.define('module-p1', class extends Widget {
    static service = 'service-module-p1';

    static render(data) {
        console.log(data);

        return Widget.parse`
        <h1>Electricity</h1>

        <h2>Result</h2>
        ${data ? `
        	<div>${data.electricity.result.meter1}</div>
			<div>${data.electricity.result.meter2}</div>
			<h2>Usage</h2>
	        <div>${data.electricity.usage.meter1}</div>
	        <div>${data.electricity.usage.meter2}</div>
        ` : `
        	Loading...
        `}
        
        <h1>Gas</h1>
		${data ? `
        	<div>Amount: ${data.gas}</div>
        ` : `
        	Loading...
        `}
        `;
    }
});