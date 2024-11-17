#!/bin/bash

# テーブル作成
aws dynamodb create-table \
    --table-name profiles \
    --attribute-definitions AttributeName=PK,AttributeType=S \
    --key-schema AttributeName=PK,KeyType=HASH \
    --billing-mode PAY_PER_REQUEST \
    --endpoint-url http://localhost:8000

# 初期データ投入
aws dynamodb put-item \
    --table-name profiles \
    --item '{
        "PK": {"S": "PROFILE#1"},
        "Name": {"S": "John Doe"},
        "Title": {"S": "Web Developer"},
        "Bio": {"S": "Hello World!"},
        "Avatar": {"S": "https://example.com/avatar.jpg"}
    }' \
    --endpoint-url http://localhost:8000
