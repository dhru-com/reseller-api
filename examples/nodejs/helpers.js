const axios = require("axios");
const config = require("./config");

/**
 * Perform an HTTP request using Axios.
 *
 * @param {string} url - The complete API endpoint URL.
 * @param {string} method - HTTP method (e.g., GET, POST, PUT, DELETE).
 * @param {Object} headers - Optional additional headers.
 * @param {Object} body - Optional request body for POST/PUT requests.
 * @returns {Object} Contains HTTP status code and response data.
 */
async function callApi(url, method = "GET", headers = {}, body = null) {
    try {
        // Add common headers like Authorization
        const commonHeaders = {
            Authorization: `Bearer ${config.BEARER_TOKEN}`,
            ...(method === "POST" || method === "PUT" ? { "Content-Type": "application/json" } : {}),
        };

        const response = await axios({
            method,
            url,
            headers: { ...commonHeaders, ...headers },
            data: body,
        });

        return {
            http_code: response.status,
            response: response.data,
        };
    } catch (error) {
        return {
            http_code: error.response?.status || 500,
            response: error.response?.data || { error: "An unexpected error occurred." },
        };
    }
}

module.exports = { callApi };
