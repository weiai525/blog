<?php
return [
    'file' => [
        'pathFormat'=>'/public/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}',
        'nameFormat'=>'',
        'size'=>20480000,
        'fileAllowFiles' => [
            '.png', '.jpg', '.jpeg', '.gif', '.bmp',
            '.flv', '.swf', '.mkv', '.avi', '.rm', '.rmvb', '.mpeg', '.mpg',
            '.ogg', '.ogv', '.mov', '.wmv', '.mp4', '.webm', '.mp3', '.wav', '.mid',
            '.rar', '.zip', '.tar', '.gz', '.7z', '.bz2', '.cab', '.iso',
            '.doc', '.docx', '.xls', '.xlsx', '.ppt', '.pptx', '.pdf', '.txt', '.md', '.xml',
        ],
        'illegalCharacter'=> ['\\','=','>','*','?','"','<','>','|'],//非法参数列表。将被过滤掉
        'fieldName'=>'file',//上传表单名称

    ],
    'image' => [
        'pathFormat'=>'/public/imagetmp/{yyyy}{mm}{dd}{time}{rand:6}',
        'size'=>20480000,
        'fileAllowFiles' => [
            '.png', '.jpg', '.jpeg', '.gif', '.bmp',
        ],
        'illegalCharacter'=> ['\\','=','>','*','?','"','<','>','|'],//非法参数列表。将被过滤掉
        'fieldName'=>'upload_file',//上传表单名称
    ],
];
