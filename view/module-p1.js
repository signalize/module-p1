import {Widget} from "js/widget.js";

export class ModuleP1 {
    constructor() {
        customElements.define('module-p1', class extends Widget {
            render() {
                let name = 'World';
                return `Hello ${name}`;
            }
        });
    }
}