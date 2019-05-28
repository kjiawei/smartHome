[<<����API�б�](../list.md)

# WebAPI����ȡ���нڵ���

***

## ������Ϣ

* ��ַ��`api/node/getAllGroup.json`

* ����ʽ��POST/GET

* ��ҪAuth����

* ���ظ�ʽ��JSON

* ����ȫ�ַ��أ���

## �������

| ���� | ���� | ���� | ʾ�� |
| --- | --- | --- | --- |
| auth | �ַ��� | ��Ȩ�ַ�����ͨ����¼API��ȡ | 21232f297a57a5a743894a0e4a801fc3 |

## ���ز���

| ���� | ���� | ���� | ʾ�� |
| --- | --- | --- | --- |
| group | ���� | ���нڵ��� | [{"id":1,"name":"Light"},{"id":2,"name":"Electronic equipment"}] |

## ����ʾ��

	curl -X POST http://client.smarthome.sylingd.com/api/node/getAllGroup.json -d 'auth=21232f297a57a5a743894a0e4a801fc3'

����ɹ���������Ϣ���£�

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

���ʧ�ܣ�������Ϣ���£�

	{
		"success": 0,
		"errcode": 1,
		"errmsg": "Auth is not exists"
	}

## ע������

group����Ϊ������

## ����������

| ������ | ���� |
| --- | --- |
| 1 | Auth�����ڻ��ѹ��� |