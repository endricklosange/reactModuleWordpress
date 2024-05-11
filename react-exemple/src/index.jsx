// in src/index.js

// Added lines to use wp.element instead of importing React
const {  render } = wp.element;
import { App } from '../component/App'


// Render the app inside our shortcode's #app div
render(
    <App />,
    document.getElementById('app')
);
