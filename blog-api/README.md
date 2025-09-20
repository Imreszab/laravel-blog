
# Laravel Blog API

This is a RESTful API for a blog application built with Laravel. It supports user authentication, blog posts, and comments.

## Project Setup

1. **Clone the repository**
2. **Install dependencies**
	```sh
	composer install
	```
3. **Copy and configure your environment file**
	```sh
	cp .env.example .env
	# Edit .env as needed (DB, mail, etc.)
	```
4. **Generate application key**
	```sh
	php artisan key:generate
	```
5. **Run migrations and seeders**
	```sh
	php artisan migrate --seed
	```
6. **(Optional) Run the development server**
	```sh
	php artisan serve
	# or
	php -S localhost:8001 -t public/
	```

## Authentication

This API uses Laravel Sanctum for authentication. Register or login to receive a token, then include it in the `Authorization: Bearer <token>` header for protected routes.

## API Endpoints

### Public Endpoints

| Method | Endpoint         | Description                |
|--------|------------------|----------------------------|
| POST   | /api/register    | Register a new user        |
| POST   | /api/login       | Login and get token        |
| GET    | /api/posts       | List all posts             |
| GET    | /api/posts/{id}  | Get a single post          |
| GET    | /api/users       | List all users             |

### Protected Endpoints (auth:sanctum)

| Method | Endpoint              | Description                    |
|--------|-----------------------|--------------------------------|
| POST   | /api/logout           | Logout (invalidate token)      |
| GET    | /api/user             | Get current authenticated user |
| POST   | /api/posts            | Create a new post              |
| PUT    | /api/posts/{id}       | Update a post (owner only)     |
| DELETE | /api/posts/{id}       | Delete a post (owner only)     |
| POST   | /api/comments         | Create a comment               |
| PUT    | /api/comments/{id}    | Update a comment (owner only)  |
| DELETE | /api/comments/{id}    | Delete a comment (owner or     |
                                 |              post  owner only) |

## Example Usage

**Register:**
```http


## API Endpoints & Definitions

### Public Endpoints

#### Register
**POST /api/register**

**Request Body:**
```
name: string (required)
email: string (required, unique)
password: string (required, min:8)
password_confirmation: string (required, same as password)
```
**Example:**
```json
{
	"name": "John Doe",
	"email": "john@example.com",
	"password": "password",
	"password_confirmation": "password"
}
```
**Response:**
```json
{
	"user": {
		"id": 1,
		"name": "John Doe",
		"email": "john@example.com",
		"created_at": "2025-09-20T12:00:00.000000Z",
		"updated_at": "2025-09-20T12:00:00.000000Z"
	},
	"token": "eyJ0eXAiOiJKV1QiLCJhbGci..."
}
```

#### Login
**POST /api/login**

**Request Body:**
```
email: string (required)
password: string (required)
```
**Example:**
```json
{
	"email": "john@example.com",
	"password": "password"
}
```
**Response:**
```json
{
	"user": {
		"id": 1,
		"name": "John Doe",
		"email": "john@example.com",
		"created_at": "2025-09-20T12:00:00.000000Z",
		"updated_at": "2025-09-20T12:00:00.000000Z"
	},
	"token": "eyJ0eXAiOiJKV1QiLCJhbGci..."
}
```


#### List All Posts
**GET /api/posts**

**Response:**
```json
[
	{
		"id": "1",
		"attributes": {
			"title": "First Post",
			"content": "This is the first post.",
			"created_at": "2025-09-20T12:00:00.000000Z",
			"updated_at": "2025-09-20T12:00:00.000000Z"
		},
		"relationships": {
			"user": {
				"id": 1,
				"user name": "John Doe"
			},
			"comments": [
				{
					"id": "10",
					"attributes": {
						"comment": "Nice post!",
						"created_at": "2025-09-20T12:10:00.000000Z",
						"updated_at": "2025-09-20T12:10:00.000000Z"
					},
					"relationships": {
						"user": {
							"id": 2,
							"name": "Jane Smith"
						},
						"post": {
							"id": 1,
							"title": "First Post"
						}
					}
				}
			]
		}
	}
]
```

#### Get Single Post
**GET /api/posts/{id}**

**Response:**
```json
{
	"id": "1",
	"attributes": {
		"title": "First Post",
		"content": "This is the first post.",
		"created_at": "2025-09-20T12:00:00.000000Z",
		"updated_at": "2025-09-20T12:00:00.000000Z"
	},
	"relationships": {
		"user": {
			"id": 1,
			"user name": "John Doe"
		},
		"comments": [
			{
				"id": "10",
				"attributes": {
					"comment": "Nice post!",
					"created_at": "2025-09-20T12:10:00.000000Z",
					"updated_at": "2025-09-20T12:10:00.000000Z"
				},
				"relationships": {
					"user": {
						"id": 2,
						"name": "Jane Smith"
					},
					"post": {
						"id": 1,
						"title": "First Post"
					}
				}
			}
		]
	}
}
```

#### List All Users
**GET /api/users**

**Response:**
```json
[
	{
		"id": 1,
		"name": "John Doe",
		"email": "john@example.com",
		"created_at": "2025-09-20T12:00:00.000000Z",
		"updated_at": "2025-09-20T12:00:00.000000Z"
	},
	{
		"id": 2,
		"name": "Jane Smith",
		"email": "jane@example.com",
		"created_at": "2025-09-20T12:10:00.000000Z",
		"updated_at": "2025-09-20T12:10:00.000000Z"
	}
]
```

### Protected Endpoints (Require Bearer Token)

#### Logout
**POST /api/logout**

**Header:**
```
Authorization: Bearer <token>
```
**Response:**
```json
{
	"message": "Logged out successfully"
}
```

#### Get Authenticated User
**GET /api/user**

**Header:**
```
Authorization: Bearer <token>
```
**Response:**
```json
{
	"id": 1,
	"name": "John Doe",
	"email": "john@example.com",
	"created_at": "2025-09-20T12:00:00.000000Z",
	"updated_at": "2025-09-20T12:00:00.000000Z"
}
```

#### Create Post
**POST /api/posts**

**Header:**
```
Authorization: Bearer <token>
```
**Request Body:**
```
title: string (required)
content: string (required)
```
**Example:**
```json
{
	"title": "New Post",
	"content": "Post content goes here."
}
```
**Response:**
```json
{
	"id": 3,
	"user_id": 1,
	"title": "New Post",
	"content": "Post content goes here.",
	"created_at": "2025-09-20T12:20:00.000000Z",
	"updated_at": "2025-09-20T12:20:00.000000Z"
}
```

#### Update Post
**PUT /api/posts/{id}**

**Header:**
```
Authorization: Bearer <token>
```
**Request Body:**
```
title: string (optional)
content: string (optional)
```
**Example:**
```json
{
	"title": "Updated Title",
	"content": "Updated content."
}
```
**Response:**
```json
{
	"id": 3,
	"user_id": 1,
	"title": "Updated Title",
	"content": "Updated content.",
	"created_at": "2025-09-20T12:20:00.000000Z",
	"updated_at": "2025-09-20T12:25:00.000000Z"
}
```

#### Delete Post
**DELETE /api/posts/{id}**

**Header:**
```
Authorization: Bearer <token>
```
**Response:**
```json
{
	"message": "Successfully deleted the Post"
}
```


#### Create Comment
**POST /api/comments**

**Header:**
```
Authorization: Bearer <token>
```
**Request Body:**
```
post_id: integer (required)
comment: string (required)
```
**Example:**
```json
{
	"post_id": 1,
	"comment": "This is a comment."
}
```
**Response:**
```json
{
	"id": "10",
	"attributes": {
		"comment": "This is a comment.",
		"created_at": "2025-09-20T12:30:00.000000Z",
		"updated_at": "2025-09-20T12:30:00.000000Z"
	},
	"relationships": {
		"user": {
			"id": 1,
			"name": "John Doe"
		},
		"post": {
			"id": 1,
			"title": "First Post"
		}
	}
}
```


#### Update Comment
**PUT /api/comments/{id}**

**Header:**
```
Authorization: Bearer <token>
```
**Request Body:**
```
comment: string (required)
```
**Example:**
```json
{
	"comment": "Updated comment."
}
```
**Response:**
```json
{
	"id": "10",
	"attributes": {
		"comment": "Updated comment.",
		"created_at": "2025-09-20T12:30:00.000000Z",
		"updated_at": "2025-09-20T12:35:00.000000Z"
	},
	"relationships": {
		"user": {
			"id": 1,
			"name": "John Doe"
		},
		"post": {
			"id": 1,
			"title": "First Post"
		}
	}
}
```

#### Delete Comment
**DELETE /api/comments/{id}**

**Header:**
```
Authorization: Bearer <token>
```
**Response:**
```json
{
	"message": "Successfully deleted the Comment"
}
```
