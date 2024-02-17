# 專案介紹

這是一個以 Dcard 為參考而實作的後端 API 專案，還會持續在新增功能

目前功能有：

-   使用者可以註冊、登入、登出
-   使用者登入後可以選擇分類新增貼文
-   使用者登入後可以對貼文進行留言
-   使用者登入後能對自己的留言進行編輯、刪除
-   使用者登入後能對貼文按愛心
-   使用者登入後能收藏貼文
-   使用者登入後能查看自己收藏的貼文

# 使用專案

### 1. clone 專案

```
git clone https://github.com/liao-chien-chun/eric_card_api.git

cd your_project
```

### 2. 複製 .env 檔

```
cp .env.example .env
```

### 3. 根據 .env 內容設定資料庫連線

### 4. 下載相關套件

```
composer install
```

### 5. 生成應用密鑰

```
php artisan key:generate
```

### 6. 設定 JWT

```
php artisan jwt:secret
```

### 7. 資料庫遷移與種子資料

```
php artisan migrate

php artisan db:seed
```

### 8. 啟動

```
php artisan serve
```

完成之後就能透過 `localhost:8000/api/v1` 去呼叫 api 了

### 伺服器 run 起來之後也能透過 url 輸入 http://localhost:8000/api/documentation 進入 Swagger 實際操作API 查看內容

## API 文件

### User (使用者) API

### 1. 使用者註冊：POST api/v1/auth/register

-   Parameters：No
-   Request Body：

```json
{
    "name": "user",
    "email": "user@gmail.com",
    "password": "12345678",
    "password_confirmation": "12345678"
}
```

-   Response
-   201 OK

```json
{
    "success": true,
    "status": 201,
    "message": "使用者註冊成功",
    "data": {
        "user": {
            "name": "eric",
            "email": "eric@gmail.com",
            "updated_at": "2024-02-17 16:59:56",
            "created_at": "2024-02-17 16:59:56",
            "id": 1
        }
    }
}
```

-   400 Bad Request

```json
{
    "success": false,
    "status": 400,
    "message": "請求參數錯誤",
    "errors": {
        "email": ["此電子郵件已經被使用"]
    }
}
```

```json
{
    "success": false,
    "status": 400,
    "message": "請求參數錯誤",
    "errors": {
        "password": ["密碼與確認密碼不符"]
    }
}
```

```json
{
    "success": false,
    "status": 400,
    "message": "請求參數錯誤",
    "errors": {
        "name": ["名字為必填"],
        "email": ["電子郵件為必填"]
    }
}
```

### 2. 使用者登入：POST api/v1/auth/login

-   Parameters：No
-   Request Body：

```json
{
    "email": "user@gmail.com",
    "password": "12345678"
}
```

-   Response
-   200 OK

```json
{
    "success": true,
    "status": 200,
    "message": "登入成功",
    "data": {
        "token": "eyJ1eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTQzLjE5OC4yMjMuNjkvYXBpL3YxL2F1dGgvbG9naW4iLCJpYXQiOjE3MDgxNjA0ODAsImV4cCI6MTcwODE2NDA4MCwibmJmIjoxNzA4MTYwNDgwLCJqdGkiOiJUSmxzMjdBS2ZsWEpvOUtsIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.9yXLfq1Ec2LxmuFYbvzjqaIUKNCZ7ZI-PDH-iQQl8-M",
        "user": {
            "id": 1,
            "name": "user",
            "email": "user@gmail.com"
        }
    }
}
```

-   400 Bad Request

```json
{
    "success": false,
    "status": 400,
    "message": "電子郵件或密碼錯誤"
}
```

-   500 Internal Server Error

```json
{
    'success' => false,
    'status' => 500,
    'message' => '無法建立token',
}
```

### 3. 使用者登出：POST api/v1/auth/logout

-   Parameters：No
-   Request Body：NO
-   Response
-   200 OK

```json
{
    "success": true,
    "status": 200,
    "message": "成功登出"
}
```

-   401 Unauthorized

```json
{
    "message": "Unauthenticated."
}
```

### Category (類別) API

### 1. 取得所有分類：GET /api/v1/categories

-   Parameters：No
-   Request Body：No
-   Response
-   200 OK

```json
{
    "success": true,
    "status": 200,
    "message": "取得所有分類成功",
    "data": [
        {
            "id": 1,
            "category_name": "科技",
            "created_at": "2024-02-14 23:02:06",
            "updated_at": null
        },
        {
            "id": 2,
            "category_name": "生活",
            "created_at": "2024-02-14 23:02:06",
            "updated_at": null
        },
        {
            "id": 3,
            "category_name": "美食",
            "created_at": "2024-02-14 23:02:06",
            "updated_at": null
        },
        {
            "id": 4,
            "category_name": "財金",
            "created_at": "2024-02-14 23:02:06",
            "updated_at": null
        },
        {
            "id": 5,
            "category_name": "工作",
            "created_at": "2024-02-14 23:02:06",
            "updated_at": null
        },
        {
            "id": 6,
            "category_name": "娛樂",
            "created_at": "2024-02-14 23:02:06",
            "updated_at": null
        },
        {
            "id": 7,
            "category_name": "心情",
            "created_at": "2024-02-14 23:02:06",
            "updated_at": null
        },
        {
            "id": 8,
            "category_name": "感情",
            "created_at": "2024-02-14 23:02:06",
            "updated_at": null
        }
    ]
}
```

### Post (文章) API

### 1. 取得所有文章：POST api/v1/posts

-   Parameters：No
-   Request Body：No
-   使用者未登入之情況
-   Response
-   200 OK

```json
{
    "success": true,
    "status": 200,
    "message": "取得所有文章成功",
    "data": [
        {
            "id": 1,
            "title": "標題1",
            "content": "文章內容1",
            "user_id": 2,
            "category_id": 1,
            "created_at": "2024-02-14 23:10:52",
            "updated_at": "2024-02-14 23:10:52",
            "comments_count": 3,
            "likers_count": 0,
            "user": {
                "id": 2,
                "name": "eric",
                "email": "eric@gmail.com"
            },
            "category": {
                "id": 1,
                "category_name": "科技",
                "created_at": "2024-02-14 23:02:06",
                "updated_at": null
            }
        },
        {
            "id": 2,
            "title": "標題2",
            "content": "文章2",
            "user_id": 2,
            "category_id": 1,
            "created_at": "2024-02-14 23:19:52",
            "updated_at": "2024-02-14 23:19:52",
            "comments_count": 0,
            "likers_count": 1,
            "user": {
                "id": 2,
                "name": "eric",
                "email": "eric@gmail.com"
            },
            "category": {
                "id": 1,
                "category_name": "科技",
                "created_at": "2024-02-14 23:02:06",
                "updated_at": null
            }
        }
    ]
}
```

-   使用者已登入之情況
-   Response
-   200 OK

```json
{
    "success": true,
    "status": 200,
    "message": "取得所有文章成功",
    "data": [
        {
            "id": 1,
            "title": "標題1",
            "content": "內文1",
            "user_id": 2,
            "category_id": 1,
            "created_at": "2024-02-14 23:10:52",
            "updated_at": "2024-02-14 23:10:52",
            "comments_count": 3,
            "likers_count": 0,
            "isCollected": true,
            "user": {
                "id": 2,
                "name": "eric",
                "email": "eric@gmail.com"
            },
            "category": {
                "id": 1,
                "category_name": "科技",
                "created_at": "2024-02-14 23:02:06",
                "updated_at": null
            }
        },
        {
            "id": 2,
            "title": "標題2",
            "content": "內文2",
            "user_id": 2,
            "category_id": 1,
            "created_at": "2024-02-14 23:19:52",
            "updated_at": "2024-02-14 23:19:52",
            "comments_count": 0,
            "likers_count": 1,
            "isCollected": true,
            "user": {
                "id": 2,
                "name": "eric",
                "email": "eric@gmail.com"
            },
            "category": {
                "id": 1,
                "category_name": "科技",
                "created_at": "2024-02-14 23:02:06",
                "updated_at": null
            }
        }
    ]
}
```

### 2. 取得單一文章：POST /api/v1/posts/:post_id

-   Parameters：

| Params  | Required | Type | Description |
| ------- | -------- | ---- | ----------- |
| post_id | Required | int  | post 的 id  |

-   Request Body：No
-   使用者未登入之情況
-   Response
-   200 OK

```json
{
    "success": true,
    "status": 200,
    "message": "取得文章成功",
    "data": {
        "id": 2,
        "title": "標題2",
        "content": "文章2",
        "user_id": 2,
        "category_id": 1,
        "created_at": "2024-02-14 23:19:52",
        "updated_at": "2024-02-14 23:19:52",
        "comments_count": 0,
        "likers_count": 1,
        "user": {
            "id": 2,
            "name": "eric",
            "email": "eric@gmail.com"
        },
        "category": {
            "id": 1,
            "category_name": "科技",
            "created_at": "2024-02-14 23:02:06",
            "updated_at": null
        }
    }
}
```

-   使用者已登入之情況
-   Response
-   200 OK

```json
{
    "success": true,
    "status": 200,
    "message": "取得文章成功",
    "data": {
        "id": 2,
        "title": "標題2",
        "content": "文章2",
        "user_id": 2,
        "category_id": 1,
        "created_at": "2024-02-14 23:19:52",
        "updated_at": "2024-02-14 23:19:52",
        "comments_count": 0,
        "likers_count": 1,
        "isLiked": true,
        "isCollected": true,
        "user": {
            "id": 2,
            "name": "eric",
            "email": "eric@gmail.com"
        },
        "category": {
            "id": 1,
            "category_name": "科技",
            "created_at": "2024-02-14 23:02:06",
            "updated_at": null
        }
    }
}
```

### 3. 取得文章留言：GET /api/v1/posts/:post_id/comments

-   Parameters：

| Params  | Required | Type | Description |
| ------- | -------- | ---- | ----------- |
| post_id | Required | int  | post 的 id  |

-   Request Body：No
-   Response
-   200 OK

```json
{
    "success": true,
    "status": 200,
    "message": "取得文章留言成功",
    "data": [
        {
            "id": 1,
            "content": "123",
            "user_id": 1,
            "post_id": 1,
            "created_at": "2024-02-15 00:22:57",
            "updated_at": "2024-02-15 21:08:39",
            "user": {
                "id": 1,
                "name": "tony",
                "email": "tony@gmail.com"
            }
        },
        {
            "id": 2,
            "content": "這是tony 的第二個留言",
            "user_id": 1,
            "post_id": 1,
            "created_at": "2024-02-15 00:23:39",
            "updated_at": "2024-02-15 00:23:39",
            "user": {
                "id": 1,
                "name": "tony",
                "email": "tony@gmail.com"
            }
        }
    ]
}
```

### 4. 對文章留言：POST /api/v1/posts/:post_id/comments

-   Parameters：

| Params  | Required | Type | Description |
| ------- | -------- | ---- | ----------- |
| post_id | Required | int  | post 的 id  |

-   Request Body

```json
{
    "content": "這是user 的第一個自己的留言"
}
```

-   Response
-   201 OK

```json
{
    "success": true,
    "status": 201,
    "message": "留言新增成功",
    "data": {
        "content": "這是user 的第一個自己的留言",
        "user_id": 2,
        "post_id": "1",
        "updated_at": "2024-02-15 21:06:06",
        "created_at": "2024-02-15 21:06:06",
        "id": 4
    }
}
```

-   400 Bad Request

```json
{
    "success": false,
    "status": 400,
    "message": "請求參數錯誤",
    "errors": {
        "content": ["留言內容不得為空"]
    }
}
```

-   500 Internal Server Error

```json
{
    'success' => false,
    'status' => 500,
    'message' => '伺服器錯誤，請稍後再試'
}
```

### 5. 修改文章留言：PATCH api/v1/posts/:post_id/comments/:comment_id

-   Parameters：

| Params     | Required | Type | Description   |
| ---------- | -------- | ---- | ------------- |
| post_id    | Required | int  | post 的 id    |
| comment_id | Required | int  | comment 的 id |

-   Request Body

```json
{
    "content": "修改留言"
}
```

-   Response
-   200 OK

```json
{
    "success": true,
    "status": 200,
    "message": "更新留言成功",
    "data": {
        "id": 1,
        "content": "123",
        "user_id": 1,
        "post_id": 1,
        "created_at": "2024-02-15 00:22:57",
        "updated_at": "2024-02-15 21:08:39"
    }
}
```

-   400 Bad Request

```json
{
    "success": false,
    "status": 400,
    "message": "請求參數錯誤",
    "errors": {
        "content": ["留言內容不得為空"]
    }
}
```
-   401 Unauthorized
```json
{
    "message": "Unauthenticated."
}
```
-   404 Not Found

```json
{
    "success": false,
    "status": 404,
    "message": "該留言不存在"
}
```

-   403 Forbidden

```json
{
    "success": false,
    "status": 403,
    "message": "沒有修改他人留言之權限"
}
```

### 6. 刪除文章留言：PATCH api/v1/posts/:post_id/comments/:comment_id

-   Parameters：

| Params     | Required | Type | Description   |
| ---------- | -------- | ---- | ------------- |
| post_id    | Required | int  | post 的 id    |
| comment_id | Required | int  | comment 的 id |

-   Request Body : No
-   Response
-   200 OK

```json
{
    "success": true,
    "status": 200,
    "message": "刪除留言成功"
}
```
-   401 Unauthorized
```json
{
    "message": "Unauthenticated."
}
```

-   404 Not Found

```json
{
    'success' => false,
    'status' => 404,
    'message' => '該留言不存在'
}
```

-   403 Forbidden

```json
{
    "success": false,
    "status": 403,
    "message": "不得刪除他人留言"
}
```
