"use strict";
var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var __assign = (this && this.__assign) || Object.assign || function(t) {
    for (var s, i = 1, n = arguments.length; i < n; i++) {
        s = arguments[i];
        for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p))
            t[p] = s[p];
    }
    return t;
};
Object.defineProperty(exports, "__esModule", { value: true });
var React = require("react");
var Checkbox_1 = require("react-bootstrap/lib/Checkbox");
var shallow_equal_fuzzy_1 = require("shallow-equal-fuzzy");
var Privilege = (function (_super) {
    __extends(Privilege, _super);
    function Privilege() {
        var _this = _super.call(this) || this;
        _this.state = {
            RoleOrUser: {
                name: '',
                slug: '',
                currentPrivileges: []
            }
        };
        return _this;
    }
    Privilege.prototype.render = function () {
        var _this = this;
        return (React.createElement("div", { id: this.props.Id, style: { maxWidth: 300, display: 'inline-block' }, className: "tabItem", "data-title": this.state.RoleOrUser.name },
            React.createElement("ul", { className: "nav nav-tabs", style: { borderBottomStyle: 'none' } },
                React.createElement("li", { className: "active" },
                    React.createElement("a", { href: "#" }, this.state.RoleOrUser.name))),
            React.createElement("div", { style: { border: "1px solid #ddd", padding: 10, backgroundColor: "#ffffff" } }, this.props.Categories.length > 0 ? this.props.Categories.map(function (category) {
                return ([
                    React.createElement("div", { key: 1, style: { display: 'inline-block', marginBottom: 5 } },
                        React.createElement(Checkbox_1.default, { style: { display: 'inline-block', margin: 0 }, value: category.slug, checked: _this.state.RoleOrUser.currentPrivileges.some(function (x) { return x == category.slug; }), onChange: _this.Changed.bind(_this) }, category.name)),
                    React.createElement("br", { key: 2 })
                ]);
            }) :
                React.createElement("div", { className: "alert alert-warning" },
                    React.createElement("h4", null,
                        React.createElement("span", { className: "glyphicon glyphicon-warning-sign" }),
                        " No WooCommerce categories found"),
                    "Did you already installed WooCommerce?"))));
    };
    Privilege.prototype.componentDidMount = function () {
        var roleUser = __assign({}, this.props.RoleOrUser);
        this.setState({
            RoleOrUser: roleUser
        });
    };
    Privilege.prototype.componentWillReceiveProps = function (nextProps, nextContext) {
        if (!shallow_equal_fuzzy_1.default(nextProps.RoleOrUser, this.props.RoleOrUser)) {
            this.setState({
                RoleOrUser: nextProps.RoleOrUser
            });
        }
    };
    Privilege.prototype.Changed = function (event) {
        var newPrivileges = __assign({}, this.state.RoleOrUser);
        var slug = event.target.value;
        var checked = event.target.checked;
        if (checked) {
            if (!newPrivileges.currentPrivileges.some(function (x) { return x == slug; }))
                newPrivileges.currentPrivileges.push(slug);
        }
        else {
            var index = newPrivileges.currentPrivileges.indexOf(slug);
            if (index >= 0)
                newPrivileges.currentPrivileges.splice(index, 1);
        }
        this.setState({ RoleOrUser: newPrivileges });
        this.props.PrivilegeUpdated(newPrivileges);
    };
    return Privilege;
}(React.Component));
exports.Privilege = Privilege;
//# sourceMappingURL=Privilege.js.map