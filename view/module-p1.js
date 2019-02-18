import {Widget} from "/js/widget.js";

customElements.define('module-p1', class extends Widget {
    static service = 'service-module-p1';

    static render(data) {
        console.log(data);

        return Widget.parse`
        <h1>Electricity</h1>

        <h2>Result</h2>
        ${data ? `
        	<div>${data.energy.usage.low}</div>
			<div>${data.energy.usage.high}</div>
			<h2>Usage</h2>
	        <div>${data.energy.result.low}</div>
	        <div>${data.energy.result.high}</div>
        ` : `
        	Loading...
        `}
        
        <h1>Gas</h1>
		${data ? `
        	<div>Amount: ${data.gas.usage.total}</div>
        ` : `
        	Loading...
        `}
        `;
    }
});