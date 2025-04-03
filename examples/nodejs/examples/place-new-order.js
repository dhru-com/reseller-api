const { callApi } = require("../helpers");
const config = require("../config");

(async () => {
    // Define the API endpoint
    const url = `${config.PROTOCOL}://${config.API_URL}/api/reseller/v1/order`;

    // Request payload for placing the order
    const data = [
        {
            product_uuid: "dd44ccc4-9139-11ef-9b79-11111111111", // Unique product/service identifier
            fields: [
                {
                    feedback_url: "https://example.com?action=feedback&order_id=112233",
                    reference_id: "112233",
                    Quantity: 1,
                    IMEI: "11111111111119",
                    username: "test-user",
                },
                {
                    feedback_url: "https://example.com?action=feedback&order_id=112234",
                    reference_id: "112234",
                    Quantity: 2,
                    IMEI: "22222222222229",
                    username: "example-user",
                },
            ],
        },
        {
            product_uuid: "ee55ddd4-9139-22ab-9b79-22222222222",
            fields: [
                {
                    feedback_url: "https://example.com?action=feedback&order_id=223344",
                    reference_id: "223344",
                    Quantity: 1,
                    IMEI: "33333333333339",
                    username: "another-user",
                },
            ],
        },
    ];

    // Make the API call to place the order
    const response = await callApi(url, "POST", {}, data);

    // Output the API response
    console.log("HTTP Code:", response.http_code);
    console.log("Response:", response.response);
})();
