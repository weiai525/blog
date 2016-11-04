module.exports = {
    xhr: new XMLHttpRequest(),
    simpleFile: function (obj) {
        "use strict";
        var fd = new FormData();
        fd.append(obj.fieldName, document.getElementById(obj.id).files[0]);
        for (var k = 0; k < obj.data.length; k++) {
            fd.append(obj.data[k]['key'], obj.data[k]['value']);
        }
        console.log(fd);
        //xhr.upload.addEventListener("progress", obj.progress, false);//加载进度
        //this.xhr.addEventListener("load", obj.success, false);//加载完成
        this.xhr.addEventListener("error", obj.error, false);
        //xhr.addEventListener("abort", obj.abort, false);//取消
        this.xhr.onreadystatechange = function (evt) {
            var xhr = evt.originalTarget;
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    (obj.success(xhr.responseText));
                } else {
                    (obj.error());
                }
            }
        };
        this.xhr.open("POST", obj.url); //
        this.xhr.send(fd);
    },
    /**
     * 文件类型是否被允许
     * description
     * @author cuibo weiai525@outlook.com at 2016-10-05
     *
     * @param  {[type]}  type [文件mime类型]
     * @param  {[type]}  obj  [允许的文件为罪名]
     * @return {Boolean}      [true]
     */
    isAllow: function (type, obj) {
        for (var k = 0; k < obj.length; k++) {
            console.log(obj[k]);
            console.log(this.fileType.hasOwnProperty(obj[k]));
            console.log(this.fileType.hasOwnProperty(obj[k]));
            console.log(type);
            if (this.fileType.hasOwnProperty(obj[k]) && type == this.fileType[obj[k]]) {
                return true;
            }
        }
        return false;
    },
    //文件为最与mime对应关系
    fileType: {
        'xls': 'application/vnd.ms-excel',
        'xlsx': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'csv': 'text/comma-separated-values'
    }
}
