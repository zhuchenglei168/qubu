var BuyRecordFun = null;
var GetGoodsFun = null;
var SingleFun = null;
$(document).ready(function() {
    var a = function() { 
        var d = $("#hdUserID");
        var l = $("#divMidNav");
        var m = $("#divBuyRecord");
        var e = $("#divGetGoods");
        var j = $("#divSingle");
        var c = 0;
        var k = $("#btnLoadMore");
        var b = $("#divLoading");
        l.find("span").each(function(p) {
            var q = $(this);
            q.click(function() {			 
                h(q, p)
            })
        });
        var h = function(q, p) {
            q.addClass("mCurr").siblings().removeClass("mCurr");
            switch (p) {
            case 0:
                c = 0;
                m.show();
                e.hide();
                j.hide();
                if (BuyRecordFun.CountFalg) {
                    k.show()
                } else {
                    k.hide()
                }
                _IsLoading = false;
                break;
            case 1:
                c = 1;
                m.hide();
                e.show();
                j.hide();
                if (!GetGoodsFun.initFlag) {
                    b.show();
                    GetGoodsFun.initData();
                    GetGoodsFun.initFlag = true
                }
                if (GetGoodsFun.CountFalg) {
                    k.show()
                } else {
                    k.hide()
                }
                _IsLoading = false;
                break;
            case 2:
                c = 2;
                m.hide();
                e.hide();
                j.show();
                if (!SingleFun.initFlag) {
                    b.show();
                    SingleFun.initData();
                    SingleFun.initFlag = true
                }
                if (SingleFun.CountFalg) {
                    k.show()
                } else {
                    k.hide()
                }
                _IsLoading = false;
                break
            }
            loadImgFun(0)
        };
        var g = function() {
            var s = Gobal.NoneHtml;
            var t = false;
            var p = false;
            var q = 0;
            var r = 10;
            var u = 0;
            this.CountFalg = false;
            var x = {
                Type: 0,
                UserID: d.val(),
                FIdx: q,
                EIdx: r,
                IsCount: 1
            };
            var w = function() {
                var y = "";
				y += "/" + x.Type;
                y += "/" + x.UserID;				
                y += "/" + x.FIdx;
                y += "/" + x.EIdx;
                y += "/" + x.IsCount;
                return y
            };
            var v = function() {
                var y = function(I) {
                    if (I.code == 0) {
                        if (x.IsCount == 1) {
                            u = I.count							 
                        }
                        var B = I.listItems;
                        var C = B.length;
                        var E = "";
                        if (B <= 0) {
                            E = s
                        }
                        for (var D = 0; D < C; D++) {
                            var F = B[D];
                            var H = F.canyurenshu;
                            var A = F.zongrenshu;
                            var G = parseFloat(H * 100 / A);
                            var z = Math.ceil(G);
                            E += "<ul onclick=\"location.href='"+Gobal.Webpath+"/mobile/mobile/item/" + F.shopid + '\'"><li class="mBuyRecordL">';
                            E += '<img src2="'+Gobal.imgpath+'/uploads/' + F.thumb + '" src="' + Gobal.LoadPic + '"></li>';
                            E += '<li class="mBuyRecordR">(Phase ' + F.qishu + ")" + F.title + "";
                            if (F.codeState == 3) {
                                E += '<p class="mValue">Price：$' + F.money + '</p><span>Winner：<a style="color: #22AAff" href="'+Gobal.Webpath+'/mobile/mobile/userindex/' + F.q_uid + '">' + F.q_user + '</a><br>Lucky code：<em class="orange">' + F.q_user_code + "</em></span>"
                            } else {
                                E += '<div class="pRate"><div class="Progress-bar">';
                                if (z == 0) {
                                    E += '<p class="u-progress"></p>'
                                } else {
                                    E += '<p class="u-progress" title="Completed ' + G + '%"><span class="pgbar" style="width: ' + z + '%;"><span class="pging"></span></span></p>'
                                }
                                E += '<ul class="Pro-bar-li">';
                                E += '<li class="P-bar01"><em>' + F.canyurenshu + '</em>Participated </li><li class="P-bar02"><em>' + F.zongrenshu + '</em>Total</li><li class="P-bar03"><em>' + (F.zongrenshu - F.canyurenshu) + "</em>Surplus</li>";
                                E += "</ul></div></div>"
                            }
                            E += "</li></ul>"
                        }
                        m.append(E);
                        s = "";
                        loadImgFun();
                        if (u > x.EIdx) {
                            _IsLoading = false;
                            k.show();
                            b.hide();
                            BuyRecordFun.CountFalg = true
                        } else {
                            k.hide();
                            b.hide();
                            BuyRecordFun.CountFalg = false
                        }
                    } else {
                        if (I.code == 1) {
                            m.append('<div class="haveNot z-minheight"><s></s><p>Only friends can watch</p></div>')
                        } else {
                            if (I.code == 2) {
                                m.append('<div class="haveNot z-minheight"><s></s><p>No public purchase record</p></div>')
                            } else {
                                m.append(s);
                                BuyRecordFun.CountFalg = false
                            }
                        }
                        k.hide();
                        b.hide()
                    }
                };				 			 
	GetJPData(Gobal.Webpath, "ajax", "getUserBuyList"+w(),y)
            };
            this.initData = function() {
                v()
            };
            this.getNextPage = function() {
                x.FIdx += r;
                x.EIdx += r;
                v()
            }
        };
        var i = function() {
            var s = Gobal.NoneHtml;
            this.initFlag = false;
            var t = false;
            var p = false;
            var q = 0;
            var r = 10;
            var u = 0;
            this.CountFalg = false;
            var x = {
                Type: 1,
                UserID: d.val(),
                FIdx: q,
                EIdx: r,
                IsCount: 1
            };
            var w = function() {
                var y = "";
                y += "/" + x.Type;
                y += "/" + x.UserID;
                y += "/" + x.FIdx;
                y += "/" + x.EIdx;
                y += "/" + x.IsCount;
                return y
            };
            var v = function() {
                var y = function(z) {
				 
                    if (z.code == 0) {
                        if (x.IsCount == 1) {
                            u = z.count
                        }
                        var D = z.listItems;
                        var E = D.length;
                        var B = "";
                        if (D <= 0) {
                            B = s
                        }
                        for (var A = 0; A < E; A++) {
                            var C = D[A];
                            B += "<ul onclick=\"location.href='"+Gobal.Webpath+"/mobile/mobile/item/" + C.id + '\'" class="BuyRecordList"><li class="mBuyRecordL">';
                            B += '<img src2="'+Gobal.imgpath+'/uploads/' + C.thumb + '" src="' + Gobal.LoadPic + '"></li>';
                            B += '<li class="mBuyRecordR">(Phase ' + C.qishu + ")" + C.title + '<p class="mValue">Price：$' + C.money + "</p>";
                            B += '<span>Lucky code：<em class="orange">' + C.q_user_code + "</em><br>Opening time：" + C.q_end_time + " </span></li></ul>"
                        }
                        e.append(B);
                        s = "";
                        loadImgFun();
                        if (u > x.EIdx) {
                            _IsLoading = false;
                            k.show();
                            b.hide();
                            GetGoodsFun.CountFalg = true
                        } else {
                            k.hide();
                            b.hide();
                            GetGoodsFun.CountFalg = false
                        }
                    } else {
                    	
                        if (z.code == 1) {
                            e.append('<div class="haveNot z-minheight"><s></s><p>Only friends can watch</p></div>')
                        } else {
                            if (z.code == 2) {
                                e.append('<div class="haveNot z-minheight"><s></s><p>No public purchase record</p></div>')
                            } else {
                                e.append(s);
                                GetGoodsFun.CountFalg = false
                            }
                        }
                        k.hide();
                        b.hide()
                    }
                };
	GetJPData(Gobal.Webpath, "ajax", "getUserBuyList"+w(),y)
            };
            this.initData = function() {
                v()
            };
            this.getNextPage = function() {
                x.FIdx += r;
                x.EIdx += r;
                v()
            }
        };
        var n = function() {
            var s = Gobal.NoneHtml;
            this.initFlag = false;
            var t = false;
            var p = false;
            var q = 0;
            var r = 10;
            var u = 0;
            this.CountFalg = false;
            var x = {
                Type: 2,
                UserID: d.val(),
                FIdx: q,
                EIdx: r,
                IsCount: 1
            };
            var w = function() {
                var y = "";
                y += "/" + x.Type;
                y += "/" + x.UserID;
                y += "/" + x.FIdx;
                y += "/" + x.EIdx;
                y += "/" + x.IsCount;
                return y
            };
            var v = function() {
                var y = function(H) {				 
                    if (H.code == 0) {
                        if (x.isCount == 1) {
                            u = H.count
                        }
                        var B = H.listItems;
                        var D = B.length;						
                        var F = "";
                        var z = "";
                        if (B <= 0) {
                            F = s
                        }
                        for (var E = 0; E < D; E++) {
                            var G = B[E];
                            z = G.sd_content;
                            if (z.length > 75) {
                                z = z.substring(0, 75) + "..."
                            }
                            F += '<li><a href="'+Gobal.Webpath+'/mobile/shaidan/detail/' + G.sd_id + '"><h3><b>' + G.sd_title + "</b><em>" + G.sd_time + "</em></h3>";
                            F += "<p>" + z + "</p><dl>";
                            var A = G.sd_thumbs.split(",");
                            for (var C = 0; C < A.length; C++) {
                                F += '<img src2="'+Gobal.imgpath+'/uploads/' + A[C] + '" src="' + Gobal.LoadPic + '">';
                                if (C >= 2) {
                                    break
                                }
                            }
                            F += "</dl></a></li>"
                        }
                        j.children().append(F);
                        s = "";
                        loadImgFun();
                        if (u > x.EIdx) {
                            _IsLoading = false;
                            k.show();
                            b.hide();
                            SingleFun.CountFalg = true
                        } else {
                            k.hide();
                            b.hide();
                            SingleFun.CountFalg = false
                        }
                    } else {
                    	
                        if (H.code == 1) {
                            j.append('<div class="haveNot z-minheight"><s></s><p>Only friends can watch</p></div>')
                        } else {
                            if (H.code == 2) {
                                j.append('<div class="haveNot z-minheight"><s></s><p>No public purchase record</p></div>')
                            } else {
                                j.children().append(s);
                                SingleFun.CountFalg = false
                            }
                        }
                        k.hide();
                        b.hide()
                    }
                };
	GetJPData(Gobal.Webpath, "ajax", "getUserBuyList"+w(),y)
            };
            this.initData = function() {
                v()
            };
            this.getNextPage = function() {
                x.FIdx += r;
                x.EIdx += r;
                v()
            }
        };
        var f = function() {
            b.show();
            switch (c) {
            case 0:
                BuyRecordFun.getNextPage();
                break;
            case 1:
                GetGoodsFun.getNextPage();
                break;
            case 2:
                SingleFun.getNextPage();
                break
            }
        };
        BuyRecordFun = new g();
        BuyRecordFun.initData();
        GetGoodsFun = new i();
        SingleFun = new n();
        k.bind("click",
        function() {
            k.hide();
            b.show();
            f()
        });
        isLoaded = true
    };
    a()
});