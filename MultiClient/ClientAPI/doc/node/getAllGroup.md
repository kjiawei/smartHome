[<<返回API列表](../list.md)

# WebAPI：获取所有节点组

***

## 基本信息

* 地址：`api/node/getAllGroup.json`

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
| group | 数组 | 所有节点组 | [{"id":1,"name":"Light"},{"id":2,"name":"Electronic equipment"}] |

## 请求示例

	curl -X POST http://client.smarthome.sylingd.com/api/node/getAllGroup.json -d 'auth=21232f297a57a5a743894a0e4a801fc3'

如果成功，返回信息如下：

	{
		"success": 1,
		"group": [
			{
				"id": 1,
				"name": "Light"
			},
			{
				"id": 2,
				"name": "Electronic equipment"
			}
		]
	}

如果失败，返回信息如下：

	{
		"success": 0,
		"errcode": 1,
		"errmsg": "Auth is not exists"
	}

## 注意事项

group可能为空数组

## 附表：错误码

| 错误码 | 描述 |
| --- | --- |
| 1 | Auth不存在或已过期 |