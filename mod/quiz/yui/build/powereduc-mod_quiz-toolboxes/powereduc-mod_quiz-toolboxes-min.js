YUI.add("powereduc-mod_quiz-toolboxes",function(u,a){var e,t,i,n="activityinstance",r="editinstructions",m="editor_displayed",o="select-multiple",c="editing_show",T="titleeditor",_={ACTIONAREA:".actions",ACTIONLINKTEXT:".actionlinktext",ACTIVITYACTION:"a.cm-edit-action[data-action], a.editing_maxmark, a.editing_section, input.shuffle_questions",ACTIVITYFORM:"span.instancemaxmarkcontainer form",ACTIVITYINSTANCE:"."+n,SECTIONINSTANCE:".sectioninstance",ACTIVITYLI:"li.activity, li.section",ACTIVITYMAXMARK:"input[name=maxmark]",COMMANDSPAN:".commands",CONTENTAFTERLINK:"div.contentafterlink",CONTENTWITHOUTLINK:"div.contentwithoutlink",DELETESECTIONICON:"a.editing_delete .icon",EDITMAXMARK:"a.editing_maxmark",EDITSECTION:"a.editing_section",EDITSECTIONICON:"a.editing_section .icon",EDITSHUFFLEQUESTIONSACTION:"input.cm-edit-action[data-action]",EDITSHUFFLEAREA:".instanceshufflequestions .shuffle-progress",HIDE:"a.editing_hide",HIGHLIGHT:"a.editing_highlight",INSTANCENAME:"span.instancename",INSTANCEMAXMARK:"span.instancemaxmark",INSTANCESECTION:"span.instancesection",INSTANCESECTIONAREA:"div.section-heading",MODINDENTDIV:".mod-indent",MODINDENTOUTER:".mod-indent-outer",NUMQUESTIONS:".numberofquestions",PAGECONTENT:"div#page-content",PAGELI:"li.page",SECTIONLI:"li.section",SECTIONUL:"ul.section",SECTIONFORM:".instancesectioncontainer form",SECTIONINPUT:"input[name=section]",SELECTMULTIPLEBUTTON:"#selectmultiplecommand",SELECTMULTIPLECANCELBUTTON:"#selectmultiplecancelcommand",SELECTMULTIPLECHECKBOX:".select-multiple-checkbox",SELECTMULTIPLEDELETEBUTTON:"#selectmultipledeletecommand",SELECTALL:"#questionselectall",SHOW:"a."+c,SLOTLI:"li.slot",SUMMARKS:".mod_quiz_summarks"},s=u.one(document.body);M.mod_quiz=M.mod_quiz||{},u.extend(e=function(){e.superclass.constructor.apply(this,arguments)},u.Base,{send_request:function(e,n,o,t){var i,s,a,c,d;for(s in e=e||{},i=this.get("config").pageparams)e[s]=i[s];if(e.sesskey=M.cfg.sesskey,e.courseid=this.get("courseid"),e.quizid=this.get("quizid"),a=M.cfg.wwwroot+this.get("ajaxurl"),c=[],d={method:"POST",data:e,on:{success:function(e,t){try{(c=u.JSON.parse(t.responseText)).error&&new M.core.ajaxException(c)}catch(i){}c.hasOwnProperty("newsummarks")&&u.one(_.SUMMARKS).setHTML(c.newsummarks),c.hasOwnProperty("newnumquestions")&&u.one(_.NUMQUESTIONS).setHTML(M.util.get_string("numquestionsx","quiz",c.newnumquestions)),o&&u.bind(o,this,c)(),n&&window.setTimeout(function(){n.hide()},400)},failure:function(e,t){n&&n.hide(),new M.core.ajaxException(t)}},context:this},t)for(s in t)d[s]=t[s];return n&&n.show(),u.io(a,d),this}},{NAME:"mod_quiz-toolbox",ATTRS:{courseid:{value:0},quizid:{value:0},ajaxurl:{value:null},config:{value:{}}}}),u.extend(t=function(){t.superclass.constructor.apply(this,arguments)},e,{editmaxmarkevents:[],NODE_PAGE:1,NODE_SLOT:2,NODE_JOIN:3,initializer:function(){M.mod_quiz.quizbase.register_module(this),u.delegate("click",this.handle_data_action,s,_.ACTIVITYACTION,this),u.delegate("click",this.handle_data_action,s,_.DEPENDENCY_LINK,this),this.initialise_select_multiple()},initialise_select_multiple:function(){u.one(_.SELECTMULTIPLEBUTTON).on("click",function(e){e.preventDefault(),u.one("body").addClass(o)}),u.one(_.SELECTMULTIPLECANCELBUTTON).on("click",function(e){e.preventDefault(),u.one("body").removeClass(o)}),u.delegate("click",this.delete_multiple_action,s,_.SELECTMULTIPLEDELETEBUTTON,this)},handle_data_action:function(e){var t=e.target,i=(t=t.test("a")?t:t.ancestor(_.ACTIVITYACTION)).getData("action"),n=t.ancestor(_.ACTIVITYLI);if(t.test("a")&&i&&n)switch(i){case"editmaxmark":this.edit_maxmark(e,t,n,i);break;case"delete":this.delete_with_confirmation(e,t,n,i);break;case"addpagebreak":case"removepagebreak":this.update_page_break(e,t,n,i);break;case"adddependency":case"removedependency":this.update_dependency(e,t,n,i)}},add_spinner:function(e){e=e.one(_.ACTIONAREA);return e?M.util.add_spinner(u,e):null},delete_with_confirmation:function(i,e,t){var n;i.preventDefault(),n=t,t=M.util.get_string("pluginname","qtype_"+n.getAttribute("class").match(/qtype_([^\s]*)/)[1]),t=M.util.get_string("confirmremovequestion","quiz",t),new M.core.confirm({question:t,modal:!0}).on("complete-yes",function(){var e=this.add_spinner(n),t={"class":"resource",action:"DELETE",id:u.PowerEduc.mod_quiz.util.slot.getId(n)};this.send_request(t,e,function(e){e.deleted&&(u.PowerEduc.mod_quiz.util.slot.remove(n),this.reorganise_edit_page(),M.core.actionmenu&&M.core.actionmenu.instance&&M.core.actionmenu.instance.hideMenu(i))})},this)},find_sections_that_would_become_empty:function(){var n,e=u.all(_.SECTIONLI);return 1<e.size()&&e.some(function(e){var t=e.one(_.INSTANCESECTION).getContent(),i=e.all(_.SELECTMULTIPLECHECKBOX+":checked"),e=e.all(_.SELECTMULTIPLECHECKBOX+":not(:checked)");return n=!i.isEmpty()&&e.isEmpty()?t:n}),n},delete_multiple_action:function(e){var t=this.find_sections_that_would_become_empty();void 0!==t?new M.core.alert({title:M.util.get_string("cannotremoveslots","quiz"),message:M.util.get_string("cannotremoveallsectionslots","quiz",t)}).show():this.delete_multiple_with_confirmation(e)},delete_multiple_with_confirmation:function(e){var i,t,n;e.preventDefault(),i="",t=[],u.all(_.SELECTMULTIPLECHECKBOX+":checked").each(function(e){e=u.PowerEduc.mod_quiz.util.slot.getSlotFromComponent(e);i=(i+=""===i?"":",")+u.PowerEduc.mod_quiz.util.slot.getId(e),t.push(e)}),n=u.one("div.mod-quiz-edit-content"),t&&t.length&&new M.core.confirm({question:M.util.get_string("areyousureremoveselected","quiz"),modal:!0}).on("complete-yes",function(){var e=this.add_spinner(n),t={"class":"resource",field:"deletemultiple",ids:i};this.send_request(t,e,function(e){e.deleted&&(u.all(_.SELECTMULTIPLECHECKBOX+":checked").each(function(e){u.PowerEduc.mod_quiz.util.slot.remove(e.ancestor("li.activity"))}),this.reorganise_edit_page(),u.one("body").removeClass(o))})},this)},edit_maxmark:function(n,e,o){var s,t=o.one(_.INSTANCEMAXMARK),a=o.one(_.ACTIVITYINSTANCE),c=t.get("firstChild").get("data"),d=c,l=t,t={
"class":"resource",field:"getmaxmark",id:u.PowerEduc.mod_quiz.util.slot.getId(o)};n.preventDefault(),this.send_request(t,null,function(e){var t,i;M.core.actionmenu&&M.core.actionmenu.instance&&M.core.actionmenu.instance.hideMenu(n),e.instancemaxmark&&(d=e.instancemaxmark),e=u.Node.create('<form action="#" />'),t=u.Node.create('<span class="'+r+'" id="id_editinstructions" />').set("innerHTML",M.util.get_string("edittitleinstructions","powereduc")),i=u.Node.create('<input name="maxmark" type="text" class="'+T+'" />').setAttrs({value:d,autocomplete:"off","aria-describedby":"id_editinstructions",maxLength:"12",size:parseInt(this.get("config").questiondecimalpoints,10)+2}),e.appendChild(i),e.setData("anchor",l),a.insert(t,"before"),l.replace(e),o.addClass(m),i.focus().select(),s=i.on("blur",this.edit_maxmark_cancel,this,o,!1),this.editmaxmarkevents.push(s),s=i.on("key",this.edit_maxmark_cancel,"esc",this,o,!0),this.editmaxmarkevents.push(s),s=e.on("submit",this.edit_maxmark_submit,this,o,c),this.editmaxmarkevents.push(s)})},edit_maxmark_submit:function(e,t,i){var n;e.preventDefault(),e=u.Lang.trim(t.one(_.ACTIVITYFORM+" "+_.ACTIVITYMAXMARK).get("value")),n=this.add_spinner(t),this.edit_maxmark_clear(t),t.one(_.INSTANCEMAXMARK).setContent(e),null!==e&&""!==e&&e!==i&&(i={"class":"resource",field:"updatemaxmark",maxmark:e,id:u.PowerEduc.mod_quiz.util.slot.getId(t)},this.send_request(i,n,function(e){e.instancemaxmark&&t.one(_.INSTANCEMAXMARK).setContent(e.instancemaxmark)}))},edit_maxmark_cancel:function(e,t,i){i&&e.preventDefault(),this.edit_maxmark_clear(t)},edit_maxmark_clear:function(e){new u.EventHandle(this.editmaxmarkevents).detach();var t=e.one(_.ACTIVITYFORM),i=e.one("#id_editinstructions");t&&t.replace(t.getData("anchor")),i&&i.remove(),e.removeClass(m),u.later(100,this,function(){e.one(_.EDITMAXMARK).focus()}),u.one("input[name=maxmark")||u.one("body").append('<input type="text" name="maxmark" style="display: none">')},update_page_break:function(e,t,i,n){var o,s;return e.preventDefault(),e=i.next("li.activity.slot"),o=this.add_spinner(e),s="removepagebreak"===n?1:2,e={"class":"resource",field:"updatepagebreak",id:u.PowerEduc.mod_quiz.util.slot.getId(e),value:s},this.send_request(e,o,function(e){e.slots&&("addpagebreak"===n?u.PowerEduc.mod_quiz.util.page.add(i):(e=i.next(u.PowerEduc.mod_quiz.util.page.SELECTORS.PAGE),u.PowerEduc.mod_quiz.util.page.remove(e,!0)),this.reorganise_edit_page())}),this},update_dependency:function(e,t,i,n){return e.preventDefault(),e=this.add_spinner(i),n={"class":"resource",field:"updatedependency",id:u.PowerEduc.mod_quiz.util.slot.getId(i),value:"adddependency"===n?1:0},this.send_request(n,e,function(e){e.hasOwnProperty("requireprevious")&&u.PowerEduc.mod_quiz.util.slot.updateDependencyIcon(i,e.requireprevious)}),this},reorganise_edit_page:function(){u.PowerEduc.mod_quiz.util.slot.reorderSlots(),u.PowerEduc.mod_quiz.util.slot.reorderPageBreaks(),u.PowerEduc.mod_quiz.util.page.reorderPages(),u.PowerEduc.mod_quiz.util.slot.updateOneSlotSections(),u.PowerEduc.mod_quiz.util.slot.updateAllDependencyIcons()},NAME:"mod_quiz-resource-toolbox",ATTRS:{courseid:{value:0},quizid:{value:0}}}),M.mod_quiz.resource_toolbox=null,M.mod_quiz.init_resource_toolbox=function(e){return M.mod_quiz.resource_toolbox=new t(e),M.mod_quiz.resource_toolbox},u.extend(i=function(){i.superclass.constructor.apply(this,arguments)},e,{editsectionevents:[],initializer:function(){M.mod_quiz.quizbase.register_module(this),s.delegate("key",this.handle_data_action,"down:enter",_.ACTIVITYACTION,this),u.delegate("click",this.handle_data_action,s,_.ACTIVITYACTION,this),u.delegate("change",this.handle_data_action,s,_.EDITSHUFFLEQUESTIONSACTION,this)},handle_data_action:function(e){var t=e.target,i=(t=t.test("a")||t.test("input[data-action]")?t:t.ancestor(_.ACTIVITYACTION)).getData("action"),n=t.ancestor(_.ACTIVITYLI);if((t.test("a")||t.test("input[data-action]"))&&i&&n)switch(i){case"edit_section_title":this.edit_section_title(e,t,n,i);break;case"shuffle_questions":this.edit_shuffle_questions(e,t,n,i);break;case"deletesection":this.delete_section_with_confirmation(e,t,n,i)}},delete_section_with_confirmation:function(e,t,i){e.preventDefault(),new M.core.confirm({question:M.util.get_string("confirmremovesectionheading","quiz",i.get("aria-label")),modal:!0}).on("complete-yes",function(){var e=M.util.add_spinner(u,i.one(_.ACTIONAREA)),t={"class":"section",action:"DELETE",id:i.get("id").replace("section-","")};this.send_request(t,e,function(e){e.deleted&&window.location.reload(!0)})},this)},edit_section_title:function(e,t,o){var s,i=o.get("id").replace("section-",""),a=o.one(_.INSTANCESECTION),c=a,i={"class":"section",field:"getsectiontitle",id:i};e.preventDefault(),this.send_request(i,null,function(e){var e=e.instancesection,t=u.Node.create('<form action="#" />'),i=u.Node.create('<span class="'+r+'" id="id_editinstructions" />').set("innerHTML",M.util.get_string("edittitleinstructions","powereduc")),n=u.Node.create('<input name="section" type="text" />').setAttrs({value:e,autocomplete:"off","aria-describedby":"id_editinstructions",maxLength:"255"});t.appendChild(n),t.setData("anchor",c),a.insert(i,"before"),c.replace(t),n.focus().select(),s=n.on("blur",this.edit_section_title_cancel,this,o,!1),this.editsectionevents.push(s),s=n.on("key",this.edit_section_title_cancel,"esc",this,o,!0),this.editsectionevents.push(s),s=t.on("submit",this.edit_section_title_submit,this,o,e),this.editsectionevents.push(s)})},edit_section_title_submit:function(e,i,t){var n;e.preventDefault(),e=u.Lang.trim(i.one(_.SECTIONFORM+" "+_.SECTIONINPUT).get("value")),n=M.util.add_spinner(u,i.one(_.INSTANCESECTIONAREA)),this.edit_section_title_clear(i),null!==e&&e!==t&&(i.one(_.INSTANCESECTION).setContent(e),t={"class":"section",field:"updatesectiontitle",newheading:e,id:i.get("id").replace("section-","")},this.send_request(t,n,function(e){var t;e&&(i.one(_.INSTANCESECTION).setContent(e.instancesection),i.one(_.EDITSECTIONICON).set("title",M.util.get_string("sectionheadingedit",
"quiz",e.instancesection)),i.one(_.EDITSECTIONICON).set("alt",M.util.get_string("sectionheadingedit","quiz",e.instancesection)),(t=i.one(_.DELETESECTIONICON))&&(t.set("title",M.util.get_string("sectionheadingremove","quiz",e.instancesection)),t.set("alt",M.util.get_string("sectionheadingremove","quiz",e.instancesection))))}))},edit_section_title_cancel:function(e,t,i){i&&e.preventDefault(),this.edit_section_title_clear(t)},edit_section_title_clear:function(e){new u.EventHandle(this.editsectionevents).detach();var t=e.one(_.SECTIONFORM),i=e.one("#id_editinstructions");t&&t.replace(t.getData("anchor")),i&&i.remove(),u.later(100,this,function(){e.one(_.EDITSECTION).focus()}),u.one("input[name=section]")||u.one("body").append('<input type="text" name="section" style="display: none">')},edit_shuffle_questions:function(e,t,i){var n=i.one(_.EDITSHUFFLEQUESTIONSACTION).get("checked")?1:0,n={"class":"section",field:"updateshufflequestions",id:i.get("id").replace("section-",""),newshuffle:n};e.preventDefault(),e=M.util.add_spinner(u,i.one(_.EDITSHUFFLEAREA)),this.send_request(n,e)}},{NAME:"mod_quiz-section-toolbox",ATTRS:{courseid:{value:0},quizid:{value:0}}}),M.mod_quiz.init_section_toolbox=function(e){return new i(e)}},"@VERSION@",{requires:["base","node","event","event-key","io","powereduc-mod_quiz-quizbase","powereduc-mod_quiz-util-slot","powereduc-core-notification-ajaxexception"]});