## サーバー死活監視/簡易版

### 概要
- 1時間ごと(`app/Console/Kernel.php` で変更可)にDB登録されたurlにgetアクセス
- 200以外のステータスコードが返ってきた場合、DB登録されたemail, slackに通知を投げる
- Lumenでよかった感あり

### DB構成

#### AccessPoint
- アクセスするWebサイトのデータ
- `register:ap {name} {url}` で登録可

|カラム|型|制約|
|---|---|---|
|id|int|Primary|
|name|string255|
|url|string255|

#### AccessNotification
- 通知先のデータ
- errorNotificationのほうがよかった説
- `register:an {name} {email?} {slack?}` で登録可
- slackURLは[Incoming Webhook](https://tsi-japan.slack.com/apps/A0F7XDUAZ--incoming-webhook-?next_id=0)

|カラム|型|制約|
|---|---|---|
|id|int|Primary|
|name|string255|
|email|string255|nullable|
|slack|string255|nullable|