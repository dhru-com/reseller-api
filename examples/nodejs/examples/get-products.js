const { callApi } = require("../helpers");
const config = require("../config");

(async () => {
    // Define the API endpoint for fetching products
    const url = `${config.PROTOCOL}://${config.API_URL}/api/reseller/v1/products`;

    // Make an API call to fetch the product list
    const response = await callApi(url, "GET");

    // Output the API response
    console.log("HTTP Code:", response.http_code);
    console.log("Response:", response.response);
})();
