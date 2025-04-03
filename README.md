# Reseller Public API Integration

This project demonstrates the integration of a Reseller Public API using PHP. It contains reusable components for API configuration, utility functions for making API calls, and example scripts for various API endpoints.

---

## Table of Contents

- [Project Structure](#project-structure)
- [Setup Instructions](#setup-instructions)
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


## Setup Instructions

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd <repository-directory>
   ```

2. Update the `config.php` file with your API details:
    - Replace the placeholders:
        - `API_URL` with the API base URL.
        - `BEARER_TOKEN` with your API token.
    - Example:
      ```php
      return [
          'API_URL' => 'https://api.example.com',
          'PROTOCOL' => 'https',
          'BEARER_TOKEN' => 'your-bearer-token',
      ];
      ```

3. Install necessary PHP extensions if not already installed:
    - Ensure `curl` is enabled in your PHP configuration (`php.ini`).

4. Run the scripts in the appropriate directories after configuring.

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

- **Run the script**:
  ```bash
  php account/get-account-info.php
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
              "type": "text",
              "name": "Recipient Name",
              "min": 3,
              "max": 50,
              "required": true
            },
            {
              "type": "text",
              "name": "Email Address",
              "min": 5,
              "max": 50,
              "required": true
            }
          ]
        },
        "bb45g678-9012-4def-82cb-456789abcd34": {
          "name": "Xbox Live Gold - 12 Month Membership",
          "type": "digital",
          "cids": ["C1", "C3"],
          "price": 59.99,
          "fields": [
            {
              "type": "text",
              "name": "Xbox Gamertag",
              "min": 3,
              "max": 50,
              "required": true
            }
          ]
        },
        "cc78h910-1234-4ghi-82dc-789012abcd56": {
          "name": "Amazon Gift Card - $100",
          "type": "digital",
          "cids": ["C2"],
          "price": 95.00,
          "fields": [
            {
              "type": "text",
              "name": "Recipient Name",
              "min": 3,
              "max": 50,
              "required": true
            },
            {
              "type": "text",
              "name": "Message",
              "min": 0,
              "max": 200,
              "required": false
            }
          ]
        }
      }
    }
  }
  ```

- **Key Fields**:
    - `status` (string): Indicates whether the request was successful (e.g., `"success"`).
    - `code` (integer): The response code (e.g., `200` for success).
    - `currency` (string): The currency in which product prices are listed (e.g., `"USD"`).
    - `categories` (object): Describes available product categories, where:
        - Each key represents a category ID (e.g., `"C1"`, `"C2"`), and its value includes:
            - `name` (string): The name of the category (e.g., `"Gaming Cards"`).
    - `products` (object): Contains detailed information about available products, where:
        - **Key**: Unique product ID (UUID).
        - **Value**: Contains product details, such as:
            - `name` (string): Product name.
            - `type` (string): Type of product (e.g., `"digital"`).
            - `cids` (array): The category IDs applicable to the product.
            - `price` (float): The product's price in the specified currency.
            - `fields` (array): Input fields required to place an order for the product:
                - `type` (string): Input type (e.g., `"text"`).
                - `name` (string): Field label (e.g., `"Recipient Name"`).
                - `required` (boolean): Specifies if the field is mandatory.
                - `min`, `max` (integer, optional): Minimum/maximum length of input.

- **Run the Script**:
  ```bash
  php products/get-products.php
  ```

### Place New Order

**File**: `orders/place-new-order.php`

This script places a new order via the `/order` API endpoint.

- **Expected Response**:
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
      }
    ]
  }
  ```

- **Run the script**:
  ```bash
  php orders/place-new-order.php
  ```

### Get Order Details

**File**: `orders/get-order-details.php`

This script retrieves details for a specific order using the `/order` API endpoint.

- **Edit `orderUuid`**:
  Replace `E121110144452240` with the actual Order UUID in the script:
  ```php
  $orderUuid = 'YOUR_ORDER_UUID';
  ```

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

- **Run the script**:
  ```bash
  php orders/get-order-details.php
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
