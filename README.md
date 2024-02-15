# 專案介紹
這是一個以Dcard 為基礎而實作的後端 API 專案
尚未完成

目前規劃功能有：
- 使用者可以註冊、登入、登出 
- 使用者登入後可以選擇分類新增貼文
- 使用者登入後可以對貼文進行留言
- 使用者登入後能對自己的留言進行編輯、刪除
- 使用者登入後能對貼文按愛心
- 使用者登入後能收藏貼文
- 使用者登入後能查看自己收藏的貼文

# 使用專案
1. clone 專案
    ```
    git clone https://github.com/liao-chien-chun/eric_card_api.git

    cd your_project
    ```

2. 設定環境檔案
   ```
   cp .env.example .env
   ```

3. 修改 .env 內容

4. 下載相關套件
    ```
    composer install
    ```
5. 生成應用密鑰
    ```
      php artisan key:generate
    ```
6. 資料庫遷移與種子資料
    ```
      php artisan migrate

      php artisan db:seed
    ```
7. 設定 JWT
    ```
      php artisan jwt:secret
    ```
8. 啟動
    ```
      php artisan serve
    ```
完成之後就能透過 localhost:8000/api/v1 去呼叫 api了

