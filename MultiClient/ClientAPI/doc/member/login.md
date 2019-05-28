[<<返回API列表](../list.md)

# WebAPI：登录

***

## 基本信息

* 地址：`api/member/login.json`

* 请求方式：POST

* 需要Auth：否

* 返回格式：JSON

* 包含全局返回：是

## 请求参数

| 名称 | 类型 | 描述 | 示例 |
| --- | --- | --- | --- |
| user | 字符串 | 用户名 | admin |
| password | 字符串 | 密码，暂时明文传输，后期可能会加密 | 123456 |

## 返回参数

| 名称 | 类型 | 描述 | 示例 |
| --- | --- | --- | --- |
| auth | 字符串 | 授权字符串，请求大部分API时需要带上，统一为小写，仅成功时存在 | 21232f297a57a5a743894a0e4a801fc3 |
| overdue | 字符串 | 授权字符串的有效期，格式类似xxxx-xx-xx，在此期间可以通过API续期，仅成功时存在 | 2014-11-16 |
| errcode | 数字 | 错误码，参见附表，仅失败时存在 | 0 |

## 请求示例

	curl -X POST http://client.smarthome.sylingd.com/api/member/login.json -d 'user=admin&password=123456'

如果成功，返回信息如下：

	{
		"success": 1,
		"auth": "21232f297a57a5a743894a0e4a801fc3",
		"overdue":"2014-11-16"
	}

如果失败，返回信息如下：

	{
		"success": 0,
		"errcode": 1,
		"errmsg": "Wrong password"
	}

## 注意事项

无

## 附表：错误码

| 错误码 | 描述 |
| --- | --- |
| 1 | 密码错误 |
| 2 | 用户不存在 |
| 3 | 用户被禁止登录 |