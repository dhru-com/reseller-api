# Reseller Public API Integration

This project demonstrates the integration of a Reseller Public API using **PHP** and **Node.js**. It includes reusable components for API configuration, utility functions for making API calls, and example scripts to interact with various API endpoints effectively.

<a href="https://documenter.getpostman.com/view/23443351/2sB2cShPhS#7fdc0833-9937-42cc-a652-c1d0d2706cdb" style="text-decoration:none;">
<img src="https://img.shields.io/static/v1?label=Postman&message=API%20Documentation&color=orange&logo=postman&logoColor=white" alt="Postman Documentation">
</a>


---

## Table of Contents

- [Project Structure](#project-structure)
- [Scripts](#scripts)
    - [Retrieve Account Information](#retrieve-account-information)
    - [Get Products](#get-products)
    - [Place New Order](#place-new-order)
    - [Get Order Details](#get-order-details)
- [Postman Documentation](#postman-documentation)
- [Configuration](#configuration)
- [API Helper Functions](#api-helper-functions)
- [Notes](#notes)
- [License](#license)

---

## Project Structure

- `config.php`  
  _Configurations for API URL, protocol, and Bearer token._

- `helpers.php`  
  _Utility functions for making API requests._

- `examples/`  
  _Contains API example scripts:_
    - `get-account-info.php` — Fetch account information.
    - `get-products.php` — Fetch available products.
    - `place-new-order.php` — Place a new order.
    - `get-order-details.php` — Retrieve details of an order.

---

## Scripts

### Retrieve Account Information

**File**: `account/get-account-info.php`

This script retrieves account details using the `/account` API endpoint.

- **Expected Response**:
  ```json
  {
    "status": "success",
    "message": "Your account details have been retrieved successfully.",
    "code": 200,
    "data": {
      "currency": "EUR",
      "balance": "450.78000",
      "name": "John Doe",
      "email": "johndoe@example.com"
    }
  }
  ```

### Get Products

**File**: `products/get-products.php`

This script fetches the list of available products and their details using the `/products` API endpoint.

- **Expected Response**:  
  The endpoint returns a JSON response in the following format:
  ```json
  {
    "status": "success",
    "code": 200,
    "data": {
      "currency": "USD",
      "categories": {
        "C1": { "name": "Gaming Cards" },
        "C2": { "name": "Gift Cards" },
        "C3": { "name": "Subscription Services" }
      },
      "products": {
        "aa12f456-7890-4abc-82fa-127890abcd12": {
          "name": "PlayStation Store Gift Card - $50",
          "type": "digital",
          "cids": ["C1", "C2"],
          "price": 45.00,
          "fields": [
            {
              "Quantity": 1,
              "IMEI": "11111111111119",
              "username": "test-user"
            }
            // Additional fields for same product...  
          ]
        }
        // Additional products...
      }
    }
  }
  ```

### Place New Order

**File**: `orders/place-new-order.php`

This script places a new order via the `/order` API endpoint.

- **Request Details**:  
  To place a new order, a POST request is sent to the `/order` endpoint with the following payload:
  ```json
  [
    {
      "product_uuid": "dd44ccc4-9139-11ef-9b79-11111111111",
      "fields": [
        {
          "feedback_url": "https://example.com?action=feedback&order_id=112233",
          "reference_id": "112233",
          "Quantity": 1,
          "IMEI": "11111111111119",
          "username": "test-user"
        },
        {
          "feedback_url": "https://example.com?action=feedback&order_id=112234",
          "reference_id": "112234",
          "Quantity": 2,
          "IMEI": "22222222222229",
          "username": "example-user"
        }
      ]
    },
    {
      "product_uuid": "ee55ddd4-9139-22ab-9b79-22222222222",
      "fields": [
        {
          "feedback_url": "https://example.com?action=feedback&order_id=223344",
          "reference_id": "223344",
          "Quantity": 1,
          "IMEI": "33333333333339",
          "username": "another-user"
        }
      ]
    }
  ]
  ```

    - **Key Fields in the Request**:
        - `product_uuid` (string) - The unique identifier of the product or service to order (mandatory).
        - `fields` (array) - An array containing details for each order request:
            - `feedback_url` (string) - Optional. A URL to receive order status updates via POST requests when the status changes.
            - `reference_id` (string) - A unique identifier for the order request (mandatory for tracking).
            - `Quantity` (integer) - Quantity of the product being ordered (mandatory).
            - Additional fields depend on the product (e.g., `"IMEI"`, `"username"`, etc.).

- **Expected Response**:
  When the request is successfully processed, the API returns a response similar to the following:
  ```json
  {
    "status": "success",
    "message": "4 Orders submitted",
    "code": 200,
    "data": [
      {
        "order_uuid": "D25040311111228272516",
        "amount": 1,
        "currency_code": "USD",
        "reference_id": "112233"
      },
      {
        "order_uuid": "Q25040311111231096887",
        "amount": 2,
        "currency_code": "USD",
        "reference_id": "112234"
      }
    ]
  }
  ```

    - **Key Fields in the Response**:
        - `status`: The status of the API call (`success` or `error`).
        - `message`: A summary of the operation performed.
        - `data`: An array of processed orders. Each object contains:
            - `order_uuid`: A unique identifier for the created order.
            - `amount`: The quantity of items processed for the order.
            - `currency_code`: The transaction's currency (e.g., `USD`).
            - `reference_id`: The reference ID provided in the request.

- **Feedback URL (`feedback_url`)**:  
  When the order's status changes (e.g., to `success` or `rejected`), a POST request is sent to the `feedback_url`.  
  Example of the POST data:
  ```json
  {
    "reference_id": "112233",
    "order_id": "K25040303033085966213",
    "status": "success",
    "replay": "YWRmc2RmYXM="
  }
  ```

    - **Key Fields in the Feedback**:
        - `reference_id`: The reference ID for the order, provided during order submission.
        - `order_id`: The unique identifier for the order.
        - `status`: The current status of the order (e.g., `success`, `rejected`).
        - `replay`: A base64-encoded message or data related to the order.

### Get Order Details

**File**: `orders/get-order-details.php`

This script retrieves details for a specific order using the `/order` API endpoint.

- **Expected Response**:
  ```json
  {
    "status": "success",
    "message": "Order Details",
    "code": 200,
    "data": {
      "quantity": 1,
      "status": "success",
      "date": "2025-04-03 11:42:00"
    }
  }
  ```

---

## Postman Documentation

Refer to the Postman documentation for further details on the API.

---

## Notes

- Ensure you have a valid Bearer Token configured in `config.php`.

---

## License

This project is licensed under the MIT License.
