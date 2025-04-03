const { callApi } = require("../helpers");
const config = require("../config");

(async () => {
    // Define the API endpoint for fetching order details
    const orderUuid = "E121110144452240"; // Replace with the actual order UUID
    const url = `${config.PROTOCOL}://${config.API_URL}/api/reseller/v1/order?order_uuid=${orderUuid}`;

    // Make an API call to fetch the order details
    const response = await callApi(url, "GET");

    // Output the API response
    console.log("HTTP Code:", response.http_code);
    console.log("Response:", response.response);
})();
