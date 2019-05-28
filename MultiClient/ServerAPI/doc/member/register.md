[<<返回API列表](../list.md)

# WebAPI：注册

***

## 基本信息

* 地址：`api/member/register.json`

* 请求方式：POST

* 需要Auth：否

* 返回格式：JSON

## 请求参数

| 名称 | 类型 | 描述 | 示例 |
| --- | --- | --- | --- |
| user | 字符串 | 用户名，仅允许数字、字母、下划线 | admin |
| familyname | 字符串 | 昵称 | Jack |
| email | 字符串 | 邮箱 | example@example.com |
| password | 字符串 | 密码，暂时明文传输，后期可能会加密 | 123456 |

## 返回参数

| 名称 | 类型 | 描述 | 示例 |
| --- | --- | --- | --- |
| success | 数字 | 是否成功，0为失败 | 1 |
| errcode | 数字 | 错误码，仅失败时存在。参见附表 | 0 |
| errmsg | 字符串 | 错误提示，仅失败时存在，为英文，可直接输出 | Format of user is incorrect |

## 请求示例

	curl -X POST http://client.smarthome.sylingd.com/api/member/register.json -d 'user=admin&familyname=Jack&email=example@example.com&password=123456'

如果成功，返回信息如下：

	{
		"success": 1
	}

如果失败，返回信息如下：

	{
		"success": 0,
		"errcode": 0,
		"errmsg": "Format of user is incorrect"
	}

## 注意事项

无

## 附表：错误码

| 错误码 | 描述 |
| --- | --- |
| 0 | 请求参数错误 |
| 1 | 用户名格式错误 |
| 2 | EMail格式错误 |
| 3 | 用户名已存在 |
| 4 | EMail已存在 |