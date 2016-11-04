module.exports = {
    CheckMail: function (mail) {
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (filter.test(mail)) return true;
        else return false;
    },
    CheckName: function (name) {
        var filter = /^[a-zA-Z][a-zA-Z0-9_@]{5,14}$/;
        if (filter.test(name)) return true;
        else return false;
    },
    CheckPassword: function (password) {
        var filter = /^[a-zA-Z0-9_@+-]{6,15}$/;
        if (filter.test(password)) return true;
        else return false;
    },
    CheckCheckbox: function (_self, min = 1) {
        var a = _self.find('#role-check input');
        var num = 0;
        for (var k in a) {
            if (a[k].checked) {
                num++;
            };
        };
        if (num >= min) {
            return true;
        } else {
            return false;
        };
    }
}
