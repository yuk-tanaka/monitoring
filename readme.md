## サーバー死活監視/簡易版

### 概要
- 1時間ごと(`app/Console/Kernel.php` で変更可)にDB登録されたurlにgetアクセス
- 200以外のステータスコードが返ってきた場合、DB登録されたemail, slackに通知を投げる
- エラーログはDBに蓄積
- 毎日23:55(`app/Console/Kernel.php` で変更可)1日のエラー件数を動作報告兼ねてslackに投げる
- Lumenでよかった感あり

### DB構成
-id, created_at, updated_at はLaravel規約準拠

#### AccessPoint
- アクセスするWebサイトのデータ
- `register:ap {name} {url}` で登録可

|カラム|型|制約|
|---|---|---|
|name|string255|
|url|string255|

#### AccessNotification
- 通知先のデータ
- 命名errorNotificationのほうがよかった説
- `register:an {name} {email?} {slack?}` で登録可
- slackURLは[Incoming Webhook](https://tsi-japan.slack.com/apps/A0F7XDUAZ--incoming-webhook-?next_id=0)

|カラム|型|制約|
|---|---|---|
|name|string255|
|email|string255|nullable|
|slack|string255|nullable|

#### ErrorLog
- エラーログ

|カラム|型|制約|
|---|---|---|
|access_point_id|int|index|
|status|string255|
|description|text|