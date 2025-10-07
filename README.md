# Event Booking System API

Backend API for an event booking platform built with Laravel, following modern coding standards.

## Project Standards

This project adheres to a strict set of coding standards, including:
- **Thin Controllers:** Business logic is delegated to Service classes.
- **Form Requests:** All POST/PUT requests are validated using Form Request classes.
- **DTOs:** `spatie/laravel-data` is used to create Data Transfer Objects from requests.
- **Enums:** PHP 8.1 Enums are used for roles and statuses.
- **Standard API Responses:** A custom `ApiResponse` trait ensures consistent JSON responses.
- **Soft Deletes:** Key models use soft deletes to prevent permanent data loss.
- **Testing with Pest:** All feature tests are written using Pest.
- **Code Formatting:** Code is formatted with Prettier.

## Requirements

- PHP >= 8.1
- Composer
- MySQL or other compatible SQL database
- Node.js & NPM

## Setup Instructions

1.  **Clone the repository:**
    ```bash
    git clone <your-repo-url>
    cd event-booking-system
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    npm install
    ```

3.  **Setup Environment:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Update your `.env` file with your database credentials.*

4.  **Run Migrations and Seed Database:**
    ```bash
    php artisan migrate:fresh --seed
    ```

5.  **Run the Server:**
    ```bash
    php artisan serve
    ```

6.  **Run the Queue Worker (for notifications):**
    ```bash
    php artisan queue:work
    ```

## Running Tests

To run the entire test suite using Pest:
```bash
php artisan test


POSTMAN JSON TO IMPORT:
{
	"info": {
		"_postman_id": "a1b2c3d4-e5f6-4a7b-8c9d-0e1f2a3b4c5d",
		"name": "Event Booking System API",
		"description": "Postman collection for the Event Booking System API.",
		"schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
	},
	"item": [
		{
			"name": "🔑 Authentication",
			"description": "Endpoints for user registration, login, and management.",
			"item": [
				{
					"name": "Register User",
					"request": {
						"method": "POST",
						"header": [],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "name",
									"value": "New Postman Customer",
									"type": "text"
								},
								{
									"key": "email",
									"value": "customer.postman@example.com",
									"type": "text"
								},
								{
									"key": "password",
									"value": "password",
									"type": "text"
								},
								{
									"key": "password_confirmation",
									"value": "password",
									"type": "text"
								}
							]
						},
						"url": {
							"raw": "{{baseUrl}}/api/register",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"register"
							]
						},
						"description": "Creates a new user account (defaults to 'customer' role)."
					},
					"response": []
				},
				{
					"name": "Login",
					"event": [
						{
							"listen": "test",
							"script": {
								"exec": [
									"var jsonData = pm.response.json();",
									"if (jsonData && jsonData.data && jsonData.data.access_token) {",
									"    pm.collectionVariables.set(\"token\", jsonData.data.access_token);",
									"}"
								],
								"type": "text/javascript"
							}
						}
					],
					"request": {
						"method": "POST",
						"header": [],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "email",
									"value": "admin1@example.com",
									"type": "text"
								},
								{
									"key": "password",
									"value": "admin123",
									"type": "text"
								}
							]
						},
						"url": {
							"raw": "{{baseUrl}}/api/login",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"login"
							]
						},
						"description": "Authenticates a user and returns a token. The token is automatically saved to the `{{token}}` collection variable."
					},
					"response": []
				},
				{
					"name": "Get Authenticated User",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "GET",
						"header": [],
						"url": {
							"raw": "{{baseUrl}}/api/me",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"me"
							]
						}
					},
					"response": []
				},
				{
					"name": "Logout",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [],
						"url": {
							"raw": "{{baseUrl}}/api/logout",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"logout"
							]
						}
					},
					"response": []
				}
			]
		},
		{
			"name": "🎉 Events",
			"description": "Event management. Create/edit actions require Organizer or Admin role.",
			"item": [
				{
					"name": "List Events",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "{{baseUrl}}/api/events?search=sit&date=2025-11-20",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"events"
							],
							"query": [
								{
									"key": "search",
									"value": "sit",
									"description": "(Optional) Search events by title.",
									"disabled": true
								},
								{
									"key": "date",
									"value": "2025-11-20",
									"description": "(Optional) Filter events by date (Y-m-d).",
									"disabled": true
								},
								{
									"key": "page",
									"value": "1",
									"description": "(Optional) Page number for pagination.",
									"disabled": true
								}
							]
						},
						"description": "Gets a paginated list of all events. This is a public route."
					},
					"response": []
				},
				{
					"name": "Get Single Event",
					"request": {
						"method": "GET",
						"header": [],
						"url": {
							"raw": "{{baseUrl}}/api/events/1",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"events",
								"1"
							]
						},
						"description": "Gets the details of a specific event, including its tickets. This is a public route."
					},
					"response": []
				},
				{
					"name": "Create Event",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "title",
									"value": "Summer Jazz Festival",
									"type": "text"
								},
								{
									"key": "description",
									"value": "The best jazz artists in a magical evening.",
									"type": "text"
								},
								{
									"key": "date",
									"value": "2026-07-15 20:00:00",
									"type": "text"
								},
								{
									"key": "location",
									"value": "Park Amphitheater",
									"type": "text"
								}
							]
						},
						"url": {
							"raw": "{{baseUrl}}/api/events",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"events"
							]
						},
						"description": "Creates a new event. Requires an Organizer or Admin token."
					},
					"response": []
				},
				{
					"name": "Update Event",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "_method",
									"value": "PUT",
									"type": "text"
								},
								{
									"key": "location",
									"value": "Grand Hall of the Main Hotel",
									"type": "text"
								}
							]
						},
						"url": {
							"raw": "{{baseUrl}}/api/events/1",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"events",
								"1"
							]
						},
						"description": "Updates an existing event. Requires a token from the event's owner (Organizer) or an Admin.\n\n**Note:** Uses POST method with a `_method: PUT` field for compatibility with form-data in Laravel."
					},
					"response": []
				},
				{
					"name": "Delete Event",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "DELETE",
						"header": [],
						"url": {
							"raw": "{{baseUrl}}/api/events/1",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"events",
								"1"
							]
						},
						"description": "Deletes an event. Requires a token from the event's owner (Organizer) or an Admin."
					},
					"response": []
				}
			]
		},
		{
			"name": "🎟️ Tickets",
			"description": "Ticket management for events.",
			"item": [
				{
					"name": "Add Ticket to Event",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "type",
									"value": "VIP",
									"type": "text"
								},
								{
									"key": "price",
									"value": "250.00",
									"type": "text"
								},
								{
									"key": "quantity",
									"value": "100",
									"type": "text"
								}
							]
						},
						"url": {
							"raw": "{{baseUrl}}/api/events/1/tickets",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"events",
								"1",
								"tickets"
							]
						},
						"description": "Adds a new ticket type to an existing event. Requires a token from the event's owner (Organizer) or an Admin."
					},
					"response": []
				},
				{
					"name": "Update Ticket",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "_method",
									"value": "PUT",
									"type": "text"
								},
								{
									"key": "price",
									"value": "275.50",
									"type": "text"
								}
							]
						},
						"url": {
							"raw": "{{baseUrl}}/api/tickets/1",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"tickets",
								"1"
							]
						},
						"description": "Updates an existing ticket. Requires a token from the event's owner (Organizer) or an Admin.\n\n**Note:** Uses POST method with a `_method: PUT` field for compatibility."
					},
					"response": []
				},
				{
					"name": "Delete Ticket",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "DELETE",
						"header": [],
						"url": {
							"raw": "{{baseUrl}}/api/tickets/1",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"tickets",
								"1"
							]
						},
						"description": "Deletes a ticket. Requires a token from the event's owner (Organizer) or an Admin."
					},
					"response": []
				}
			]
		},
		{
			"name": "🛍️ Bookings",
			"description": "Booking operations performed by customers.",
			"item": [
				{
					"name": "Create Booking",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "quantity",
									"value": "2",
									"type": "text"
								}
							]
						},
						"url": {
							"raw": "{{baseUrl}}/api/tickets/1/bookings",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"tickets",
								"1",
								"bookings"
							]
						},
						"description": "A customer creates a booking for a specific ticket. Requires a Customer token."
					},
					"response": []
				},
				{
					"name": "List My Bookings",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "GET",
						"header": [],
						"url": {
							"raw": "{{baseUrl}}/api/bookings",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"bookings"
							]
						},
						"description": "Lists all bookings made by the authenticated customer. Requires a Customer token."
					},
					"response": []
				},
				{
					"name": "Cancel Booking",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "_method",
									"value": "PUT",
									"type": "text"
								}
							]
						},
						"url": {
							"raw": "{{baseUrl}}/api/bookings/1/cancel",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"bookings",
								"1",
								"cancel"
							]
						},
						"description": "Cancels a pending booking. Requires a token from the Customer who owns the booking."
					},
					"response": []
				}
			]
		},
		{
			"name": "💳 Payments",
			"description": "Processing payments for bookings.",
			"item": [
				{
					"name": "Process Payment for Booking",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [],
						"url": {
							"raw": "{{baseUrl}}/api/bookings/1/payment",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"bookings",
								"1",
								"payment"
							]
						},
						"description": "Initiates the (mock) payment process for a pending booking. Requires a token from the Customer who owns the booking."
					},
					"response": []
				},
				{
					"name": "Get Payment Details",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "{{token}}",
									"type": "string"
								}
							]
						},
						"method": "GET",
						"header": [],
						"url": {
							"raw": "{{baseUrl}}/api/payments/1",
							"host": [
								"{{baseUrl}}"
							],
							"path": [
								"api",
								"payments",
								"1"
							]
						},
						"description": "Gets the details of a specific payment. Requires a token from the user who owns the payment, or an Admin."
					},
					"response": []
				}
			]
		}
	],
	"variable": [
		{
			"key": "baseUrl",
			"value": "http://automatedpros-assessment.test"
		},
		{
			"key": "token",
			"value": ""
		}
	]
}