import {Widget} from "/js/widget.js";

customElements.define('module-p1', class extends Widget {
    channel = 'service-module-p1';

    render() {
        let name = 'World';
        return `Hello ${name}`;
    }
});