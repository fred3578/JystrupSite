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
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : new P(function (resolve) { resolve(result.value); }).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var __generator = (this && this.__generator) || function (thisArg, body) {
    var _ = { label: 0, sent: function() { if (t[0] & 1) throw t[1]; return t[1]; }, trys: [], ops: [] }, f, y, t, g;
    return g = { next: verb(0), "throw": verb(1), "return": verb(2) }, typeof Symbol === "function" && (g[Symbol.iterator] = function() { return this; }), g;
    function verb(n) { return function (v) { return step([n, v]); }; }
    function step(op) {
        if (f) throw new TypeError("Generator is already executing.");
        while (_) try {
            if (f = 1, y && (t = y[op[0] & 2 ? "return" : op[0] ? "throw" : "next"]) && !(t = t.call(y, op[1])).done) return t;
            if (y = 0, t) op = [0, t.value];
            switch (op[0]) {
                case 0: case 1: t = op; break;
                case 4: _.label++; return { value: op[1], done: false };
                case 5: _.label++; y = op[1]; op = [0]; continue;
                case 7: op = _.ops.pop(); _.trys.pop(); continue;
                default:
                    if (!(t = _.trys, t = t.length > 0 && t[t.length - 1]) && (op[0] === 6 || op[0] === 2)) { _ = 0; continue; }
                    if (op[0] === 3 && (!t || (op[1] > t[0] && op[1] < t[3]))) { _.label = op[1]; break; }
                    if (op[0] === 6 && _.label < t[1]) { _.label = t[1]; t = op; break; }
                    if (t && _.label < t[2]) { _.label = t[2]; _.ops.push(op); break; }
                    if (t[2]) _.ops.pop();
                    _.trys.pop(); continue;
            }
            op = body.call(thisArg, _);
        } catch (e) { op = [6, e]; y = 0; } finally { f = t = 0; }
        if (op[0] & 5) throw op[1]; return { value: op[0] ? op[1] : void 0, done: true };
    }
};
Object.defineProperty(exports, "__esModule", { value: true });
var ReactDOM = require("react-dom");
var React = require("react");
var react_ladda_1 = require("react-ladda");
var rednao_search_box_1 = require("rednao-search-box");
var Privilege_1 = require("./Privilege");
require("../../../css/bootstrap-fix.css");
require("../../../css/mainApp.css");
require("../../../css/fontAwesome/css/font-awesome.css");
var Shuffle = require("shufflejs");
var rednao_async_ajax_1 = require("rednao-async-ajax");
var toastr = require("rednao_toastr");
require("rednao_polyfill");
var App = (function (_super) {
    __extends(App, _super);
    function App() {
        var _this = _super.call(this) || this;
        _this.showUsers = false;
        _this.roleOrUsers = [];
        _this.categories = rednaoWcrbcParams.categories;
        _this.state = {
            saving: false,
            filterString: '',
            loading: true
        };
        _this = _super.call(this) || this;
        return _this;
    }
    App.prototype.componentDidMount = function () {
        this.InitializeShuffle();
        this.ExecuteSearch('');
    };
    App.prototype.InitializeShuffle = function () {
        this.shuffle = new Shuffle(document.querySelector('.tabItemContainer'), { itemSelector: '.tabItem' });
        this.shuffle.sort({
            by: function (element) { return element.getAttribute('data-title').toLowerCase(); }
        });
    };
    App.prototype.Saving = function () {
        return __awaiter(this, void 0, void 0, function () {
            var result;
            return __generator(this, function (_a) {
                switch (_a.label) {
                    case 0:
                        this.setState({ saving: true });
                        return [4 /*yield*/, rednao_async_ajax_1.default.Post(ajaxurl, { action: 'rednao_wcrbc_save_roles', data: JSON.stringify(this.roleOrUsers), type: 'role' })];
                    case 1:
                        result = _a.sent();
                        if (result != null && result.success)
                            toastr.success("Save Successfull!");
                        else
                            toastr.error("Sorry, the data couldn't be saved. Please try again.");
                        this.setState({ saving: false });
                        return [2 /*return*/];
                }
            });
        });
    };
    /*{this.state.roleOrUsers.map((role: RoleOrUser) => {
                                            return <Privilege key={role.slug} Categories={this.categories}
                                                              RoleOrUser={role}></Privilege>
                                        })}*/
    App.prototype.render = function () {
        var _this = this;
        return React.createElement("div", { style: { padding: 10 }, className: "bootstrap-wrapper" },
            React.createElement("h1", null, rednaoWcrbcParams.title),
            React.createElement(react_ladda_1.default, { "data-style": "expand-right", loading: this.state.saving, onClick: this.Saving.bind(this), className: "btn btn-success" },
                React.createElement("span", { className: "glyphicon glyphicon-floppy-disk" }),
                " Save"),
            React.createElement(rednao_search_box_1.default, { placeholder: "Filter Roles", style: { width: 300, float: 'right' }, onBoxKeyUp: function (e) { _this.ExecuteSearch(e); } }),
            React.createElement("div", { className: "tabContainer", style: { minHeight: 300 } }, [React.createElement("div", { key: 1, className: "tabItemContainer" }),
                React.createElement("div", { className: "backDrop " + (this.state.loading ? "rednao_visible" : "rednao_hidden"), key: "backDrop", style: { backgroundColor: '#dfd', width: '100%', height: '100%', top: 0, left: 0, position: 'absolute', opacity: .2 } }),
                React.createElement("div", { className: "loadingScreen " + (this.state.loading ? "rednao_visible" : "rednao_hidden"), key: "LoadingScreen", style: { display: 'flex', justifyContent: 'center', alignItems: 'center', flexDirection: 'column', width: '100%', height: '100%', top: 0, left: 0, position: 'absolute' } },
                    React.createElement("i", { className: "fa fa-refresh fa-spin fa-3x fa-fw" }),
                    React.createElement("span", { style: { fontSize: 30 } }, rednaoWcrbcParams.loading_message))
            ]));
    };
    App.prototype.ExecuteSearch = function (text) {
        return __awaiter(this, void 0, void 0, function () {
            var result, addedEllements, removedElements, _loop_1, _i, _a, existingRoles, _loop_2, this_1, _b, result_1, newRoles, itemContainer, self, _c, addedEllements_1, addedElement, element, div, _d, removedElements_1, removedElement;
            return __generator(this, function (_e) {
                switch (_e.label) {
                    case 0:
                        this.setState({ loading: true });
                        if (this.executeSearchCancelToken != null)
                            this.executeSearchCancelToken.Cancel();
                        return [4 /*yield*/, rednao_async_ajax_1.default.CancellablePost(ajaxurl, { action: rednaoWcrbcParams.search_action, searchTerm: text }, this.executeSearchCancelToken = new rednao_async_ajax_1.CancellationToken())];
                    case 1:
                        result = _e.sent();
                        this.executeSearchCancelToken = null;
                        if (result == null)
                            result = [];
                        addedEllements = [];
                        removedElements = [];
                        _loop_1 = function (existingRoles) {
                            if (!result.some(function (x) { return x.slug == existingRoles.slug; }))
                                removedElements.push(existingRoles);
                        };
                        for (_i = 0, _a = this.roleOrUsers; _i < _a.length; _i++) {
                            existingRoles = _a[_i];
                            _loop_1(existingRoles);
                        }
                        _loop_2 = function (newRoles) {
                            if (!this_1.roleOrUsers.some(function (x) { return x.slug == newRoles.slug; }))
                                addedEllements.push(newRoles);
                        };
                        this_1 = this;
                        for (_b = 0, result_1 = result; _b < result_1.length; _b++) {
                            newRoles = result_1[_b];
                            _loop_2(newRoles);
                        }
                        itemContainer = document.querySelector('.tabItemContainer');
                        self = this;
                        for (_c = 0, addedEllements_1 = addedEllements; _c < addedEllements_1.length; _c++) {
                            addedElement = addedEllements_1[_c];
                            element = React.createElement(Privilege_1.Privilege, { key: addedElement.slug, Categories: this.categories, RoleOrUser: addedElement, Id: 'catid_' + addedElement.slug, PrivilegeUpdated: this.PrivilegeUpdated.bind(this) });
                            div = document.createElement('div');
                            ReactDOM.render(element, div, function () {
                                var element = ReactDOM.findDOMNode(this);
                                itemContainer.appendChild(element);
                                self.shuffle.add([element]);
                                self.shuffle._onResize();
                            });
                        }
                        for (_d = 0, removedElements_1 = removedElements; _d < removedElements_1.length; _d++) {
                            removedElement = removedElements_1[_d];
                            this.shuffle.remove([document.querySelector('#catid_' + removedElement.slug)]);
                        }
                        this.roleOrUsers = result;
                        this.setState({ loading: false });
                        return [2 /*return*/];
                }
            });
        });
    };
    App.prototype.PrivilegeUpdated = function (roleOrUser) {
        for (var i = 0; i < this.roleOrUsers.length; i++)
            if (this.roleOrUsers[i].slug == roleOrUser.slug)
                this.roleOrUsers[i] = __assign({}, roleOrUser);
    };
    return App;
}(React.Component));
jQuery(function () {
    ReactDOM.render(React.createElement(App, null), document.getElementById('wcrbc-main'));
});
//# sourceMappingURL=App.js.map