[<<返回API列表](../list.md)

# WebAPI：登录

***

## 基本信息

* 地址：`api/member/login.json`

* 请求方式：POST

* 需要Auth：否

* 返回格式：JSON

## 请求参数

| 名称 | 类型 | 描述 | 示例 |
| --- | --- | --- | --- |
| user | 字符串 | 用户名 | admin |
| password | 字符串 | 密码，暂时明文传输，后期可能会加密 | 123456

## 返回参数

| 名称 | 类型 | 描述 | 示例 |
| --- | --- | --- | --- |
| success | 数字 | 是否成功，0为失败 | 1 |
| auth | 字符串 | 授权字符串，请求大部分API时需要带上，统一为小写，仅成功时返回 | 21232f297a57a5a743894a0e4a801fc3 |
| errcode | 数字 | 错误码，参见附表 | 0 |
| errmsg | 字符串 | 错误提示，为英文，可直接输出 | Wrong password |

## 请求示例

	curl -X POST http://server.smarthome.sylingd.com/api/member/login.json -d 'user=admin&password=123456'

如果成功，返回信息如下：

	{
		"success": 1,
		"auth": "21232f297a57a5a743894a0e4a801fc3"
	}

如果失败，返回信息如下：

	{
		"success": 0,
		"errcode": 0,
		"errmsg": "Wrong password"
	}

## 注意事项

无

## 附表：错误码

| 错误码 | 描述 |
| --- | --- |
| 0 | 密码错误 |
| 1 | 用户不存在 |
| 2 | 用户被禁止登录 |
| 3 | 请求参数错误 |