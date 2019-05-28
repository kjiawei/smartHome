[<<返回API列表](../list.md)

# WebAPI：获取“我的信息”

***

## 基本信息

* 地址：`api/member/myInfo.json`

* 请求方式：POST/GET

* 需要Auth：是

* 返回格式：JSON

* 包含全局返回：是

## 请求参数

| 名称 | 类型 | 描述 | 示例 |
| --- | --- | --- | --- |
| auth | 字符串 | 授权字符串，通过登录API获取 | 21232f297a57a5a743894a0e4a801fc3 |

## 返回参数

| 名称 | 类型 | 描述 | 示例 |
| --- | --- | --- | --- |
| name | 字符串 | 用户名 | admin |
| group | 数字 | 用户组 | 1 |
| isAdmin | 数字 | 是否为管理员，1为是 | 1 |
| view | 数组 | 允许查看的节点组，如果为全部，则返回["*"] | ["1","3"] |
| control | 数组 | 允许控制的节点组，如果为全部，则返回["*"] | ["1","3"] |
| errcode | 数字 | 错误码，参见附表，仅失败时存在 | 0 |

## 请求示例

	curl -X POST http://client.smarthome.sylingd.com/api/member/myInfo.json -d 'auth=21232f297a57a5a743894a0e4a801fc3'

如果成功，返回信息如下：

	{
		"success": 1,
		"name": "admin",
		"group": 1,
		"isAdmin": 1,
		"view": ["1","3"],
		"control": ["1","3"]
	}

如果失败，返回信息如下：

	{
		"success": 0,
		"errcode": 1,
		"errmsg": "Auth is not exists"
	}

## 注意事项

view和control可能为空数组

## 附表：错误码

| 错误码 | 描述 |
| --- | --- |
| 1 | Auth不存在或已过期 |