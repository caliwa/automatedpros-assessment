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
		"description": "Colección de Postman para la API del Sistema de Reserva de Eventos.",
		"schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
	},
	"item": [
		{
			"name": "🔑 Authentication",
			"description": "Endpoints para registrar, autenticar y gestionar usuarios.",
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
									"value": "Nuevo Cliente Postman",
									"type": "text"
								},
								{
									"key": "email",
									"value": "cliente.postman@example.com",
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
						"description": "Crea una nueva cuenta de usuario (rol 'customer' por defecto)."
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
									"value": "admin@example.com",
									"type": "text"
								},
								{
									"key": "password",
									"value": "password",
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
						"description": "Autentica un usuario y retorna un token. El token se guarda automáticamente en la variable de colección `{{token}}`."
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
			"description": "Gestión de eventos. Las rutas de creación/edición requieren rol de Organizador o Admin.",
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
									"description": "(Opcional) Busca eventos por título.",
									"disabled": true
								},
								{
									"key": "date",
									"value": "2025-11-20",
									"description": "(Opcional) Filtra eventos por fecha (Y-m-d).",
									"disabled": true
								},
								{
									"key": "page",
									"value": "1",
									"description": "(Opcional) Número de página para la paginación.",
									"disabled": true
								}
							]
						},
						"description": "Obtiene una lista paginada de todos los eventos. Es una ruta pública."
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
						"description": "Obtiene los detalles de un evento específico, incluyendo sus tickets. Es una ruta pública."
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
									"value": "Festival de Jazz de Verano",
									"type": "text"
								},
								{
									"key": "description",
									"value": "Los mejores artistas de jazz en una noche mágica.",
									"type": "text"
								},
								{
									"key": "date",
									"value": "2025-12-10 19:30:00",
									"type": "text"
								},
								{
									"key": "location",
									"value": "Anfiteatro del Parque",
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
						"description": "Crea un nuevo evento. Requiere token de Organizador o Admin."
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
									"value": "Gran Salón del Hotel Principal",
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
						"description": "Actualiza un evento existente. Requiere token del Organizador dueño del evento o de un Admin.\n\n**Nota:** Se usa el método POST con el campo `_method: PUT` para compatibilidad con `form-data` en Laravel."
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
						"description": "Elimina un evento. Requiere token del Organizador dueño del evento o de un Admin."
					},
					"response": []
				}
			]
		},
		{
			"name": "🎟️ Tickets",
			"description": "Gestión de tickets para eventos.",
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
						"description": "Añade un nuevo tipo de ticket a un evento existente. Requiere token del Organizador dueño del evento o de un Admin."
					},
					"response": []
				}
			]
		},
		{
			"name": "🛍️ Bookings",
			"description": "Operaciones de reserva realizadas por clientes.",
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
						"description": "Un cliente crea una reserva para un ticket específico. Requiere token de Cliente."
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
						"description": "Lista todas las reservas hechas por el cliente autenticado. Requiere token de Cliente."
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
						"description": "Cancela una reserva pendiente. Requiere token del Cliente dueño de la reserva."
					},
					"response": []
				}
			]
		},
		{
			"name": "💳 Payments",
			"description": "Procesamiento de pagos para las reservas.",
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
						"description": "Inicia el procesamiento de pago (simulado) para una reserva pendiente. Requiere token del Cliente dueño de la reserva."
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