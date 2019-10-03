/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');
import BootstrapVue from 'bootstrap-vue'
import '../../public/js/chosen.jquery.js';
import '../../public/js/tinymce/tinymce.min.js';
import '../../public/js/owl.carousel.min.js';
import datePicker from 'vue-bootstrap-datetimepicker';
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
import Vue from 'vue';
import VeeValidate from 'vee-validate';
import { Printd } from 'printd'

Vue.prototype.trans = (key) => {
    return _.get(window.trans, key, key);
};
Vue.use(datePicker);
Vue.use(BootstrapVue);
Vue.use(VeeValidate);

jQuery(document).ready(function () {

    /*--------------------------------------
     MOBILE MENU
     --------------------------------------*/
    function collapseMenu() {
        jQuery('.sj-navigation ul li.menu-item-has-children, .sj-navigation ul li.page_item_has_children, .sj-navigation ul li.menu-item-has-mega-menu').prepend('<span class="sj-dropdowarrow"><i class="fa fa-angle-down"></i></span>');
        jQuery('.sj-navigation ul li.menu-item-has-children span, .sj-navigation ul li.page_item_has_children span, .sj-navigation ul li.menu-item-has-mega-menu span').on('click', function () {
            jQuery(this).parent('li').toggleClass('sj-open');
            jQuery(this).next().next().slideToggle(300);
        });
    }
    collapseMenu();
    /*--------------------------------------
     MEGA MENU
     --------------------------------------*/
    jQuery(function ($) {
        function hoverIn() {
            var a = jQuery(this);
            var nav = a.closest('.sj-navigation');
            var mega = a.find('.mega-menu');
            var offset = rightSide(nav) - leftSide(a);
            mega.width(Math.min(rightSide(nav), columns(mega) * 230));
            mega.css('left', Math.min(0, offset - mega.width()));
        }
        function hoverOut() {
        }
        function columns(mega) {
            var columns = 0;
            mega.children('.mega-menu-row').each(function () {
                columns = Math.max(columns, jQuery(this).children('.mega-menu-col').length);
            });
            return columns;
        }
        function leftSide(elem) {
            return elem.offset().left;
        }
        function rightSide(elem) {
            return elem.offset().left + elem.width();
        }
        jQuery('.menu-item-has-mega-menu').hover(hoverIn, hoverOut);
    });

    jQuery(function () {
        jQuery('a[href="#sj-searcharea"]').on('click', function (event) {
            event.preventDefault();
            jQuery('.sj-searcharea').addClass('open');
            jQuery('.sj-searcharea > form > input[type="search"]').focus();
        });
        jQuery('.sj-searcharea, .sj-searcharea button.close').on('click keyup', function (event) {
            if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
                jQuery(this).removeClass('open');
            }
        });
    });

    tinymce.init({
        selector: 'textarea.page-textarea',
        height: 350,
        plugins: 'print code preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools contextmenu colorpicker textpattern help',
        menubar: "",
        toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code | preview| link image',
        image_advtab: true,
        branding: false,
        relative_urls: false,
        remove_script_host: false,
        setup: function (ed) {
            if (document.getElementById("new_article")) {
                ed.on('keyup', function (e) {
                    new_article_obj.autoComplete();
                });
            }
        }
    });

    jQuery('#sj-homebanner').owlCarousel({
        items: 1,
        nav: false,
        loop: true,
        dots: false,
        autoplay: true,
        dotsClass: 'sj-sliderdots'
    });

    jQuery('#sj-editionslider').owlCarousel({
        items: 3,
        nav: false,
        loop: false,
        dots: false,
        autoplay: true,
        dotsClass: 'sj-sliderdots'
    });

    jQuery('#sj-welcomeimgslider').owlCarousel({
        items: 1,
        nav: false,
        loop: true,
        dots: false,
        autoplay: true,
        dotsClass: 'sj-sliderdots',
        navClass: ['sj-prev', 'sj-next'],
        navContainerClass: 'sj-slidernav',
        navText: ['<span class="icon-chevron-left"></span>', '<span class="icon-chevron-right"></span>'],
    });

    jQuery(".sj-btnscrolltotop").on('click', function () {
        var _scrollUp = jQuery('html, body');
        _scrollUp.animate({ scrollTop: 0 }, 'slow');
    });

    jQuery('.sj-userdropdownbtn').on('click', function (event) {
        var _this = jQuery(this);
        event.preventDefault();
        _this.closest('.sj-categorysinfo').siblings('.sj-categorysinfo').find('.sj-userdropdownmanu').slideUp();
        _this.siblings('.sj-userdropdownmanu').slideToggle();
    });

    jQuery(document).ready(function () {
        jQuery('.chosen-select').chosen();
    });

    if ($('ul.sub-menu li').hasClass("current-menu-item")) {
        $('ul.sub-menu li.current-menu-item').parent().parent().addClass("current-menu-item");
    }

});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('upload-files', require('./components/FileUploadComponent.vue'));
Vue.component('upload-files-field', require('./components/FileUploadFieldComponent.vue'));
Vue.component('sticky_messages', require('./components/sticky_messages.vue'));
Vue.component('flash_messages', require('./components/flash_messages.vue'));
Vue.component('email_fields', require('./components/EmailFieldsComponent.vue'));
Vue.component('image-upload', require('./components/ImageUploaderComponent.vue'));
Vue.component('switch_button', require('./components/SwitchButton.vue'));

window.messageVue = new Vue();
window.flashVue = new Vue();
window.fileVue = new Vue();

if (document.getElementById("account_setting")) {
    const vmaccountsetting = new Vue({
        el: '#account_setting',
        mounted: function () {
            if (document.getElementsByClassName("toast-holder") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: {
            is_error: false,
            config: {
                img_deleted: APP_URL + "/dashboard/general/settings/account-settings/delete-image",
                img_upload: APP_URL+"/dashboard/general/settings/account-settings/upload-image",
                get_img: APP_URL + "/dashboard/general/settings/account-settings/get-image"
            }
        }
    });
}
if (document.getElementById("author_article")) {
    const vmauthorarticle = new Vue({
        el: '#author_article',
        mounted: function () {
            if (document.getElementsByClassName("toast-holder") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: {
            file_input_name: 'resubmit_article',
            notified: true,
            is_error: false,
        },
        methods: {
            author_notified: function (event) {
                var element = event.currentTarget
                this.elementID = element.getAttribute('id');
                this.background = false;
                var self = this;
                axios.post(APP_URL + '/author/user/article/author-notified', {
                        ID: this.elementID
                    })
                    .then(function (response) {
                        self.notified = false;
                    })
                    .catch(function (error) {
                        //console.log(error);
                    });
            }
        }
    });
}
if (document.getElementById("new_article")) {
    var new_article_obj = new Vue({
        el: '#new_article',
        created: function () { },
        data: {
            author: {
                author_name: '',
                author_email: '',
                count: 0
            },
            authors: [],
            title_check: false,
            title_na: true,
            abst_na: true,
            abst_check: false,
            author_check: false,
            author_na: true,
            title_error: true,
            title_completed: false,
            abst_error: true,
            abst_completed: false,
            excerpt_error: true,
            excerpt_completed: false,
            excerpt_check: false,
            excerpt_na: true,
            author_error: true,
            author_completed: false,
            upload_file_check: false,
            upload_file_na: true,
            upload_file_error: true,
            upload_file_completed: false,
            uploading: false,
            completed: 0,
            first_author_name: "",
            first_author_email: "",
            title: "",
            abstract: "",
            excerpt: "",
            price: "",
            form_errors: [],
            custom_error: false,
            progressing: false,
            file_input_name: 'uploaded_new_article',
            create_article: 'create_article',
            formErrors: '',
            loading: false,
            notified: true
        },
        ready: function () {
            this.watchFileInput();
            this.notifyFileInput();
            this.checkCompleted();
            this.options();
            this.date();
            this.autoComplete();
        },
        mounted: function () {
            if (document.getElementsByClassName("toast-holder") != null) {
                flashVue.$emit('showFlashMessage');
            }
            this.upload_file_check = false;
            this.upload_file_na = true;
            this.upload_file_error = true;
            this.upload_file_completed = false;
            $(document).on('change', '#create_article', function (e) {
                var _this = $(this);
                _this.parents('#new_article').find('.sj-profilecomplete .uploadfilestatus.sj-profileerror').removeClass('sj-profileerror');
                _this.parents('#new_article').find('.sj-profilecomplete .uploadfilestatus').addClass('sj-profilecompleted');
                _this.parents('#new_article').find('.sj-profilecomplete .uploadstatusinner.ti-na').removeClass('ti-na');
                _this.parents('#new_article').find('.sj-profilecomplete .uploadstatusinner').addClass('ti-check');
            });
            $(document).on('click', '.clear_data', function (e) {
                var _this = $(this);
                _this.parents('#new_article').find('.sj-profilecomplete .uploadfilestatus.sj-profilecompleted').removeClass('sj-profilecompleted');
                _this.parents('#new_article').find('.sj-profilecomplete .uploadfilestatus').addClass('sj-profileerror');
                _this.parents('#new_article').find('.sj-profilecomplete .uploadstatusinner.ti-check').removeClass('ti-check');
                _this.parents('#new_article').find('.sj-profilecomplete .uploadstatusinner').addClass('ti-na');
            });
        },
        methods: {
            addAnother: function () {
                this.authors.push(Vue.util.extend({}, this.author, this.author.count++))
            },
            removeAuthor: function (index) {
                Vue.delete(this.authors, index);
            },
            checkForm: function (e) {
                var abstract = tinyMCE.get('abstract').getContent();
                var fileInput = document.getElementById("create_article").value;
                var article_title = document.querySelector("input[name=title]").value;
                var first_author_name = document.getElementById("first_author_name").value;
                var first_author_email = document.getElementById("first_author_email").value;
                var excerpt = document.getElementById("excerpt").value;
                if (first_author_name && first_author_email && article_title && abstract && excerpt && fileInput) {
                    this.loading = true;
                    this.progressing = true;
                    messageVue.$emit('showAlert')
                    this.custom_error = false;
                    return true;
                }
                this.form_errors = [];
                this.custom_error = true;
                var self = this;
                axios.post(APP_URL + '/author/user/article/new-article-custom-errors')
                    .then(function (response) {
                        if (!article_title) self.form_errors.push(response.data.article_title_error);
                        if (!first_author_name) self.form_errors.push(response.data.author_name_error);
                        if (!first_author_email) self.form_errors.push(response.data.author_email_error);
                        if (!abstract) self.form_errors.push(response.data.article_desc_error);
                        if (!excerpt) self.form_errors.push(response.data.article_excerpt_error);
                        if (!fileInput) self.form_errors.push(response.data.article_doc_error);
                        setTimeout(function () {
                            self.custom_error = false;
                        }, 3000);
                    })
                    .catch(function (error) {
                        //console.log(error.response.data);
                    });

                e.preventDefault();
            },
            autoComplete: function () {
                var title = document.querySelector("input[name=title]").value;
                var abstract = tinyMCE.get('abstract').getContent();
                var author_title = document.querySelector(".author_title").value;
                var author_email = document.querySelector(".author_email").value;
                var excerpt = document.querySelector(".excerpt").value;
                var fileInput = document.getElementById("create_article").value;

                var checked_value = "";
                this.title_na = true;
                this.title_check = false;
                this.abst_na = true;
                this.abst_check = false;
                this.author_na = true;
                this.author_check = false;
                this.excerpt_na = true;
                this.excerpt_check = false;
                this.upload_file_check = false;
                this.upload_file_na = true;

                this.title_error = true;
                this.title_completed = false;
                this.abst_error = true;
                this.abst_completed = false;
                this.author_error = true;
                this.author_completed = false;
                this.excerpt_error = true;
                this.excerpt_completed = false;
                this.upload_file_error = true;
                this.upload_file_completed = false;

                if (title) {
                    this.title_na = false;
                    this.title_check = true;
                    this.title_error = false;
                    this.title_completed = true;
                }

                if (abstract) {
                    this.abst_na = false;
                    this.abst_check = true;
                    this.abst_completed = true;
                    this.abst_error = false;
                }

                if (excerpt) {
                    this.excerpt_na = false;
                    this.excerpt_check = true;
                    this.excerpt_completed = true;
                    this.excerpt_error = false;
                }

                if (author_title && author_email) {
                    this.author_na = false;
                    this.author_check = true;
                    this.author_completed = true;
                    this.author_error = false;
                }

                if (fileInput) {
                    this.upload_file_check = false;
                    this.upload_file_na = true;
                    this.upload_file_error = true;
                    this.upload_file_completed = false;
                }

            }
        }
    });
}
if (document.getElementById("article")) {
    var vm = new Vue({
        el: '#article',

        data: {
            elementID: "",
            background: true,
            success_message: "",
            editionelementID: "",
            assign_article_pdf: 'assign_article_pdf',
            file_name: 'article_pdf',
            is_error: false,
            notified: true
        },
        mounted: function () {
            if (document.getElementsByClassName("toast-holder") != null) {
                flashVue.$emit('showFlashMessage');
            }
            this.is_error = true;
            var self = this;
            setTimeout(function () {
                self.is_error = false;
            }, 3000);
        },
        methods: {
            func: function (event) {
                var element = event.currentTarget
                this.elementID = element.getAttribute('id');
                this.background = false;
                this.is_error = false;
                var self = this;
                axios.post(APP_URL + '/notify-article-review', {
                        ID: this.elementID
                    })
                    .then(function (response) {
                        self.notified = false;
                    })
                    .catch(function (error) {
                        //console.log(error);
                    });
            }
        }
    });
}
if (document.getElementById("article_detail")) {
    new Vue({
        el: '#article_detail',
        data: {
            success_message: '',
            loading: false
        },
        mounted: function () {
            jQuery(document).ready(function () {
                jQuery('.chosen-select').chosen();
            });
        },
        methods: {
            assign_reviewer_article: function (event) {
                this.loading = true;
                var formContents = jQuery("#assign_reviewer_article").serialize();
                var self = this;
                axios.post(APP_URL + '/' + USER_ROLE + '/dashboard/assign-reviewer', formContents)
                    .then(function (response) {
                        self.loading = false;
                        //console.log(response);
                        self.success_message = response.data.message;
                        messageVue.$emit('showAlert')
                    })
                    .catch(function (error) {
                        //console.log(error.response.data);
                    });
            },
            showloading: function () {
                this.loading = true;
            }
        }
    });
}
if (document.getElementById("manage_page")) {
    new Vue({
        el: '#manage_page',
        mounted: function () {
            if (document.getElementsByClassName("toast-holder") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        created: function(){
            this.getPageOption();
        },
        data: {
            show_page: false,
            delete_title: '',
            delete_message: '',
            deleted: '',
            message: ''
        },
        methods: {
            deletePage: function (event, delete_title, delete_message, deleted) {
                var element = event.currentTarget
                this.editionelementID = element.getAttribute('id');
                let self = this;
                swal({
                    title: delete_title,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function (isConfirm) {
                    var page_id = element.getAttribute('id')
                    if (isConfirm) {
                        axios.post(APP_URL + '/' + USER_ROLE + '/dashboard/pages/page/delete-page', {
                                id: page_id
                            })
                            .then(function (response) {
                                if (response.data.type === 'error') {
                                    self.message = response.data.message;
                                    messageVue.$emit('showAlert');
                                } else {
                                    setTimeout(function () {
                                        swal({
                                            title: deleted,
                                            text: delete_message,
                                            type: "success"
                                        })
                                    }, 500);
                                    jQuery('.delPage-' + page_id).remove();
                                }
                            });
                    } else {
                        swal("Cancelled");
                    }
                });
            },
            getPageOption: function(){
                var segment_str = window.location.pathname;
                var segment_array = segment_str.split( '/' );
                var id = segment_array[segment_array.length - 2];
                if (segment_str == '/superadmin/dashboard/pages/page/'+id+'/edit-page') {
                    let self = this;
                    axios.post(APP_URL + '/superadmin/dashboard/pages/page/edit-page',{
                        page_id:id
                    })
                    .then(function (response) {
                        if (response.data.type == 'success') {
                            if(response.data.show_page == 'true') {
                                self.show_page = true;
                            } else {
                                self.show_page = false;
                            }
                        }
                    });
                }
            },
        }
    });
}

if (document.getElementById("general_setting")) {
    new Vue({
        el: '#general_setting',
        data: {
            //doc: 'Upload Your File Here',
            elementID: "",
            editionelementID: "",
            categoryID: "",
            editionID: "",
            userID: "",
            message: "",
            loading: false,
            file_input_name: 'category_image',
            date: null,
            selected_date: '',
            create_category: 'new_category',
            edit_category: 'edit_category',
            delete_category_title: '',
            delete_edition_title: '',
            category_delete_message: '',
            edition_delete_message: '',
            deleted: '',
            is_error: false,
            error: '',
            article_errors: [],
            config: {
                format: 'YYYY-MM-DD',
                useCurrent: false,
                showClear: true,
                showClose: true

            }
        },
        mounted: function () {
            if (document.getElementsByClassName("toast-holder") != null) {
                flashVue.$emit('showFlashMessage');
            }
            this.is_error = true;
            var self = this;
            setTimeout(function () {
                self.is_error = false;
            }, 3000);
        },
        ready: function () {
            this.fetchCategoryList();
            this.watchFileDOC();
            this.notifyFileDOC();
            this.deleteCategory();
            this.deleteEdition();
            this.deleteUser();
            this.publishEdition();
         },
        methods: {
            deleteCategory: function (event, delete_category_title, category_delete_message, deleted) {
                var element = event.currentTarget
                this.elementID = element.getAttribute('id');
                var self = this;
                swal({
                    title: delete_category_title,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function (isConfirm) {
                    var category_id = element.getAttribute('id')
                    if (isConfirm) {
                        axios.post(APP_URL + '/dashboard/general/settings/category-delete', {
                                id: category_id
                            })
                            .then(function (response) {
                                if (response.data.type === 'error') {
                                    self.message = response.data.message;
                                    messageVue.$emit('showAlert');
                                } else {
                                    setTimeout(function () {
                                        swal({
                                            title: deleted,
                                            text: category_delete_message,
                                            type: "success"
                                        })
                                    }, 500);
                                    jQuery('.del-' + category_id).remove();
                                }
                            })
                    } else {
                        swal("Cancelled");
                    }
                });
            },
            deleteEdition: function (event, delete_edition_title, edition_delete_message, deleted) {
                var element = event.currentTarget
                var self = this;
                this.editionelementID = element.getAttribute('id');
                swal({
                    title: delete_edition_title,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function (isConfirm) {
                    var edition_id = element.getAttribute('id')
                    if (isConfirm) {
                        axios.post(APP_URL + '/dashboard/general/settings/delete-edition', {
                                id: edition_id
                            })
                            .then(function (response) {
                                if(response.data.type === 'error'){
                                    self.message = response.data.message;
                                    messageVue.$emit('showAlert');
                                }else{
                                    setTimeout(function () {
                                        swal({
                                            title: deleted,
                                            text: edition_delete_message,
                                            type: "success"
                                        })
                                    }, 500);
                                    jQuery('.delEdition-' + edition_id).remove();
                                }
                                //console.log(response);
                            })

                    } else {
                        swal("Cancelled");
                    }
                });
            },
            publishEdition: function (event) {
                var element = event.currentTarget;
                var edition_id = element.getAttribute('id');
                var self = this;
                this.loading = true;
                jQuery('body').addClass('sj-show-loader');
                axios.post(APP_URL + '/dashboard/general/settings/publish-edition', {
                        id: edition_id
                    })
                    .then(function (response) {
                        if (response.data.error) {
                            self.message = response.data.error;
                            self.loading = false;
                            jQuery('body').removeClass('sj-show-loader');
                            messageVue.$emit('showAlert');
                        } else {
                            self.message = response.data.message;
                            var link = APP_URL + '/edition/' + response.data.edition_slug;
                            var edition_menu = document.getElementById("edition_menu");
                            var navItem = document.createElement("li");
                            var navLink = document.createElement("a");
                            navLink.href = link;
                            navLink.innerHTML = response.data.edition_title;
                            navItem.appendChild(navLink);
                            edition_menu.appendChild(navItem);
                            self.loading = false;
                            jQuery('body').removeClass('sj-show-loader');
                            messageVue.$emit('showAlert');
                        }
                    })
                    .catch(function (error) {
                        //console.log(error.response.data);
                    });

            },
            watchFileDOC: function () {
                $('input[type="file"]').change(this.notifyFileDOC.bind(this));
            },
            notifyFileDOC: function (event) {
                var element = event.currentTarget
                var fileName = event.target.files[0].name;
                this.doc = fileName;
            }
        }

    });
}
if (document.getElementById("user_management")) {
    new Vue({
        el: '#user_management',
        mounted: function () {
            if (document.getElementsByClassName("toast-holder") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: {
            loading: false,
            success_message: '',
            delete_title: '',
            delete_message: '',
            deleted: '',
            server_error: ''
        },
        methods: {
            deleteUser: function (event, delete_title, delete_message, deleted) {
                var element = event.currentTarget
                this.userelementID = element.getAttribute('id');
                var self = this;
                swal({
                    title: delete_title,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function (isConfirm) {
                    var user_id = element.getAttribute('id')
                    if (isConfirm) {
                        axios.post(APP_URL + '/superadmin/users/delete-user', {
                                id: user_id
                            })
                            .then(function (response) {
                                if (response.data.type === 'error') {
                                    self.success_message = response.data.message;
                                    messageVue.$emit('showAlert');
                                } else {
                                    setTimeout(function () {
                                        swal({
                                            title: deleted,
                                            text: delete_message,
                                            type: "success"
                                        })
                                    }, 500);
                                    jQuery('.delUser-' + user_id).remove();
                                }
                            });

                    } else {
                        swal("Cancelled");
                    }
                });
            },
            assignCategory: function (event) {
                this.loading = true;
                var element = event.currentTarget
                var user_form_id = element.getAttribute('id');
                var formContents = jQuery("#" + user_form_id).serialize();
                var self = this;
                axios.post(APP_URL + '/' + USER_ROLE + '/users/assign-category', formContents)
                    .then(function (response) {
                        self.loading = false;
                        console.log(response);
                        self.success_message = response.data.message;
                        messageVue.$emit('showAlert')
                    })
                    .catch(function (error) {
                        //console.log(error.response.data);
                    });

            },
            submitRoleForm: function () {
                document.getElementById("role_filter_form").submit();
            }
        }
    });
}
if (document.getElementById("site_management")) {
    new Vue({
        el: '#site_management',
        mounted: function () {
            if (document.getElementsByClassName("toast-holder") != null) {
                flashVue.$emit('showFlashMessage');
            }
            var count_social_length = jQuery('.social-icons-content').find('.wrap-social-icons').length;
            count_social_length = count_social_length - 1;
            this.social.count = count_social_length;
            //Delete Social Icons Event
            jQuery(document).on('click', '.delete-social', function (e) {
                e.preventDefault();
                var _this = jQuery(this);
                _this.parents('.wrap-social-icons').remove();
            });
            //Home Slider
            var count_slides_length = jQuery('.home-slider-content').find('.wrap-home-slider').length;
            count_slides_length = count_slides_length - 1;
            this.slide.slide_count = count_slides_length;
            //Welcome Slider
            var count_welcome_slides_length = jQuery('.welcome-slider-content').find('.wrap-welcome-slider').length;
            count_welcome_slides_length = count_welcome_slides_length - 1;
            this.welcome_slide.slide_count = count_welcome_slides_length;
            //Delete Home Banner Slides Event
            jQuery(document).on('click', '.delete-slide', function (e) {
                e.preventDefault();
                var _this = jQuery(this);
                _this.parents('.wrap-home-slider').remove();
            });
            //Delete Welcome Slides Event
            jQuery(document).on('click', '.delete-slide', function (e) {
                e.preventDefault();
                var _this = jQuery(this);
                _this.parents('.wrap-welcome-slider').remove();
            });
            jQuery(document).ready(function () {
                jQuery('.chosen-select').chosen();
            });
        },
        data: {
            social: {
                social_name: 'select social icon',
                social_url: '',
                count: 0,
                success_message: '',
                loading: false
            },
            slide: {
                slide_img: '',
                slide_title: 'Slide Title',
                slide_desc: 'Slide Description',
                slide_count: 0,
                image_id: 'image_id',
                slide_input_name: '',
                title_placeholder: 'Title',
                description_placeholder: 'Description'
            },
            welcome_slide: {
                slide_img: '',
                slide_count: 0,
                image_id: 'welcome_image_id',
                slide_input_name: ''
            },
            socials: [],
            first_social_name: '',
            first_social_url: '',
            file_input_name: 'slide[0][image]',
            upload_logo: 'upload_logo',
            slides: [],
            welcome_slides: [],
            first_slide_img_id: 'image_id',
            first_slide_title: '',
            first_slide_desc: '',
            store_file_input_name: 'slide',
            store_file_input_image: '[image]',
            store_welcome_file_input_image: '[welcome_image]',
            message: '',
            first_slider_from_db: '',
            config: {
                img_deleted: APP_URL+'/dashboard/'+USER_ROLE+'/site-management/delete-logo',
                img_upload: APP_URL+'/dashboard/'+USER_ROLE+'/site-management/store-logo',
                get_img: APP_URL+'/dashboard/'+USER_ROLE+'/site-management/logo/get-logo'
            },
            adconfig: {
                img_deleted: APP_URL+'/dashboard/'+USER_ROLE+'/site-management/delete-advertise',
                img_upload: APP_URL+'/dashboard/'+USER_ROLE+'/site-management/store-advertise-image',
                get_img: APP_URL+'/dashboard/'+USER_ROLE+'/site-management/advertise/get-advertise-image'
            }
        },
        ready: function () {

        },
        methods: {
            addSocial: function () {
                this.socials.push(Vue.util.extend({}, this.social, this.social.count++))
            },
            removeSocial: function (index) {
                Vue.delete(this.socials, index);
            },
            //Home Sliders Add/Delete
            addSlide: function () {
                this.slides.push(Vue.util.extend({}, this.slide, this.slide.slide_count++, this.slide.slide_input_name = 'slide' + '[' + this.slide.slide_count + ']' + '[image]'));
            },
            removeSlide: function (index) {
                Vue.delete(this.slides, index);
            },
            // Welcome Sliders Add/Delete
            addWelcomeSlide: function () {
                this.welcome_slides.push(Vue.util.extend({}, this.welcome_slide, this.welcome_slide.slide_count++, this.welcome_slide.slide_input_name = 'slide' + '[' + this.welcome_slide.slide_count + ']' + '[welcome_image]'));
            },
            removeWelcomeSlide: function (index) {
                Vue.delete(this.welcome_slides, index);
            },
            //Resource Page Widgets
            resource_page_widget: function (event) {
                this.loading = true;
                var formContents = jQuery("#resource_page_widget").serialize();
                var self = this;
                axios.post(APP_URL + '/dashboard/' + USER_ROLE + '/site-management/store/store-resource-pages', formContents)
                .then(function (response) {
                    self.loading = false;
                    //console.log(response);
                    self.message = response.data.message;
                    messageVue.$emit('showAlert')
                    if (response.data.pages) {
                        var pages = response.data.pages;
                        var total = $('ul#resource-menu li').length;
                        var lastindexval = [];
                        if (total > 0) {
                            $( "ul#resource-menu li a" ).each(function(index, obj) {
                                var href = $(this).attr('href').split('/');
                                lastindexval.push(href[href.length-1]) ;
                            });
                        }
                        pages.forEach(element => {
                            if (!(lastindexval.includes(element.slug))) {
                                var link = APP_URL + '/page/' + element.slug;
                                var resource_menu = document.getElementById("resource-menu");
                                var navItem = document.createElement("li");
                                var navLink = document.createElement("a");
                                navLink.href = link;
                                navLink.innerHTML = element.title;
                                navItem.appendChild(navLink);
                                resource_menu.appendChild(navItem);
                            }
                        });
                    }
                })
                .catch(function (error) {
                    //console.log(error.response.data);
                });
            },
            //Clear All Cache
            clearAllCache: function () {
                var self = this;
                swal({
                    title: 'Clear All Cache',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        axios.get(APP_URL + '/dashboard/superadmin/site-management/cache/clear-allcache')
                        .then(function (response) {
                            if (response.data.type === 'error') {
                                self.message = response.data.message;
                                messageVue.$emit('showAlert');
                            } else {
                                setTimeout(function () {
                                    swal({
                                        title: 'Cleared',
                                        text: 'Cache Cleared',
                                        type: "success"
                                    })
                                }, 500);
                                swal.close();
                            }
                        });
                    } else {
                        swal("Cancelled");
                    }
                });
            },
        }
    });
}
if (document.getElementById("article_sidebar")) {
    new Vue({
        el: '#article_sidebar',
        mounted: function () { },
        data: { }
    });
}
if (document.getElementById("email_templates")) {
    new Vue({
        el: '#email_templates',
        mounted: function () {
            if (document.getElementsByClassName("toast-holder") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: {
            delete_title: '',
            delete_message: '',
            deleted: '',
            user_types: '',
            variables: '',
            error: '',
            selected_email_type: ''
        },
        ready: function () {
            this.deleteTemplate();
        },
        methods: {
            deleteTemplate: function (event, delete_title, delete_message, deleted) {
                var element = event.currentTarget
                this.editionelementID = element.getAttribute('id');
                swal({
                    title: delete_title,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function (isConfirm) {
                    var template_id = element.getAttribute('id')
                    if (isConfirm) {
                        axios.post(APP_URL + '/superadmin/emails/email/delete-template', {
                                id: template_id
                            })
                            .then(function (response) {
                                //(response);
                            });
                        setTimeout(function () {
                            swal({
                                title: deleted,
                                text: delete_message,
                                type: "success"
                            })
                        }, 500);
                        jQuery('.delTemplate-' + template_id).remove();
                    } else {
                        swal("Cancelled");
                    }
                });
            },
            getUserType: function (event) {
                var element = event.currentTarget;
                var elementID = element.getAttribute('id');
                var selected_email_type = jQuery('#' + elementID).val();
                var self = this;
                axios.post(APP_URL + '/dashboard/superadmin/emails/get-email-user-type', {
                        email_type: selected_email_type
                    })
                    .then(function (response) {
                        if (response.data.error) {
                            self.error = response.data.error;
                        }
                    })
                    .catch(function (error) {
                        //console.log(error.response.data);
                    });
            },
            getEmailVariables: function (event) {
                var element = event.currentTarget;
                var elementID = element.getAttribute('id');
                var role_id = jQuery('#' + elementID).val();
                var self = this;
                axios.post(APP_URL + '/dashboard/superadmin/emails/get-email-variables', {
                        role_id: role_id,
                        email_type: self.selected_email_type
                    })
                    .then(function (response) {
                        self.variables = response.data.variables;
                        self.show = true;
                    })
                    .catch(function (error) {
                        //console.log(error.response.data);
                    });
            },
            submitTemplateFilter: function () {
                document.getElementById("template_filter_form").submit();
            }
        }
    });
}
if (document.getElementById("public_publish_articles")) {
    new Vue({
        el: '#public_publish_articles',
        mounted: function () { },
        data: { },
        methods: {
            onChange: function () {
                document.getElementById("edition_filters").submit();
            }
        }
    });
}
if (document.getElementById("user_register")) {
    new Vue({
        el: '#user_register',
        mounted: function () {
            if (document.getElementsByClassName("toast-holder") != null) {
                flashVue.$emit('showFlashMessage');
            }
         },
        data: {
            loading: false
        },
        methods: {
            showloading: function () {
                this.loading = true;
            }
        }
    });
}
if (document.getElementById("reviewer_feedback")) {
    new Vue({
        el: '#reviewer_feedback',
        mounted: function () {
            if (document.getElementsByClassName("toast-holder") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
        data: {
            loading: false,
        },
        methods: {
            showloading: function () {
                this.loading = true;
            }
        }
    });
}
if (document.getElementById("invoice_list")) {
    new Vue({
        el: '#invoice_list',
        mounted: function () {
            // $('.print-window').click(function() {
            //     window.print();
            // });
        },
        data: { },
        methods: {
            print: function () {
                const cssText = `
                .sj-transactionhold{
                    float: left;
                    width: 100%;
                }
                .sj-borderheadingvtwo a{font-size: 18px;}
                .sj-transactiondetails{
                    float: left;
                    width: 100%;
                    list-style:none;
                    margin-bottom:20px;
                    line-height: 28px;
                }
                .sj-transactiondetails li{
                    float: left;
                    width: 100%;
                    margin-bottom: 10px;
                    line-height: inherit;
                    list-style-type:none;
                }
                .sj-transactiondetails li:last-child{margin: 0;}
                .sj-transactiondetails li span{
                    font-size: 16px;
                    line-height: inherit;
                }
                .sj-transactiondetails li span.sj-grossamount {float: right;}
                .sj-transactiondetails li span em{
                    font-weight:500;
                    font-style:normal;
                    line-height: inherit;
                }
                .sj-transactionid{
                    margin-left:80px;
                    padding-left:10px;
                    border-left:2px solid #ddd;
                }
                .sj-grossamountusd{font-size: 24px !important;}
                .sj-paymentstatus{
                    color: #21ce93;
                    padding:3px 10px;
                    margin-left:10px;
                    font-size: 14px !important;
                    text-transform: uppercase;
                    border:1px solid #21ce93;
                }
                .sj-createtransactionhold{
                    float: left;
                    width: 100%;
                }
                .sj-createtransactionholdvtwo{
                    padding:0 20px;
                }
                .sj-createtransactionheading{
                    float: left;
                    width: 100%;
                    padding-bottom:15px;
                    border-bottom:1px solid #ddd;
                }
                .sj-createtransactionheading span{
                    display: block;
                    color: #1070c4;
                    font-size: 16px;
                    line-height: 20px;
                }
                .sj-createtransactioncontent{
                    float: left;
                    width: 100%;
                    padding:27px 0;
                    border-bottom: 1px solid #ddd;
                }
                .sj-createtransactioncontent a{
                    padding:0 10px;
                    color: #1070c4;
                    font-size: 14px;
                    line-height: 16px;
                    display: inline-block;
                    vertical-align: middle;
                    border-left:1px solid #ddd;
                }
                .sj-createtransactioncontent a:first-child{
                    border-left:0;
                    padding-left:0;
                }
                .sj-addresshold{
                    float: left;
                    width: 100%;
                    padding:18px 0;
                }
                .sj-addresshold h4{
                    margin: 0;
                    display: block;
                    font-size: 16px;
                    font-weight: 500;
                }
                table.sj-carttable{ margin-bottom:0;}
                table.sj-carttable thead{
                    border:0;
                    font-size:14px;
                    line-height:18px;
                    background: #f5f7fa;
                }
                table.sj-carttable thead tr th{
                    border:0;
                    text-align:left;
                    font-weight: 500;
                    font-weight:normal;
                    padding:20px 4px 20px 160px;
                    font:500 16px/18px 'Montserrat', Arial, Helvetica, sans-serif;
                }
                table.sj-carttable thead tr th + th{
                    text-align:center;
                    padding:20px 4px;
                }
                table.sj-carttable tbody td{
                    width:50%;
                    border:0;
                    font-size:16px;
                    text-align:left;
                    line-height: 20px;
                    display:table-cell;
                    vertical-align:middle;
                    padding:10px 4px 10px 0;
                }
                table.sj-carttable tbody td span,
                table.sj-carttable tbody td img{
                    display:inline-block;
                    vertical-align:middle;
                }
                table.sj-carttable tbody td em{
                    margin: 0;
                    font-size: 16px;
                    line-height: 16px;
                    font-style: normal;
                    vertical-align: middle;
                    display: inline-block;
                }
                table.sj-carttable > thead > tr > th{
                    padding: 6px 20px;
                    width: 25%;
                }
                table.sj-carttable > thead:first-child > tr:first-child > th{
                    border:0;
                    width: 25%;
                    padding: 6px 20px;
                }
                table.sj-carttable tbody td > em{
                    display: block;
                    text-align: center;
                }
                table.sj-carttable tbody td img{
                    width: 116px;
                    height: 116px;
                    margin-right:20px;
                    border-radius:10px;
                }
                table.sj-carttable tbody td + td{
                    width:15%;
                    text-align:center;
                }
                table.sj-carttable tbody td:last-child{
                    width:10%;
                    text-align:right;
                    padding:20px 20px 20px 4px;
                }
                table.sj-carttable tbody td .btn-delete-item{
                    float:right;
                    font-size:24px;
                }
                table.sj-carttable tbody td .btn-delete-item a{color: #fe6767}
                table.sj-carttable tbody td .quantity-sapn{
                    padding:0;
                    width:80px;
                    position:relative;
                    border-radius: 10px;
                    border: 1px solid #e7e7e7;
                }
                table.sj-carttable tbody td .quantity-sapn input[type="text"]{
                    width: 100%;
                    height: 42px;
                    padding: 0 15px;
                    border-radius: 0;
                    box-shadow: none;
                    background: none;
                    line-height: 42px;
                }
                table.sj-carttable tbody td .quantity-sapn input{border:0;}
                table.sj-carttable tbody td .quantity-sapn em{
                    width:10px;
                    display:block;
                    position:absolute;
                    right:10px;
                    cursor:pointer;
                }
                table.sj-carttable tbody td .quantity-sapn em.fa-caret-up{top:8px;}
                table.sj-carttable tbody td .quantity-sapn em.fa-caret-down{ bottom:8px;}
                table.sj-carttable tfoot tr td{ width:50%;}
                table.sj-carttable tbody tr{border-bottom: 1px solid #ddd;}
                table.sj-carttable tbody tr:last-child{border-bottom:0; }
                table.sj-carttablevtwo tbody td > em{
                    color: #636c77;
                    font-weight:500;
                    text-align: left;
                    display: inline-block;
                }
                table.sj-carttablevtwo tbody td > span{
                    float: right;
                }
                table.sj-carttablevtwo tbody td{padding:20px;}

                .sj-refundscontent{
                    float: left;
                    width: 100%;
                }
                .sj-refundsdetails{
                    float: left;
                    width: 100%;
                    list-style:none;
                }
                .sj-refundsdetails li{
                    float: left;
                    width: 100%;
                    padding:15px 0;
                    list-style-type:none;
                }
                .sj-refundsdetails li + li{border-top: 1px solid #ddd;}
                .sj-refundsdetails li strong{
                    width: 300px;
                    float:left;
                }
                .sj-refundsdetails li .sj-rightarea{float: left;}
                .sj-refundsdetails li .sj-rightarea span{
                    display: block;
                }
                .sj-refundsdetails li .sj-rightarea em{
                    font-weight:500;
                    font-style: normal;
                }
                .sj-refundsdetails li:nth-child(3){
                    border:0;
                    padding-top:0;
                }
                .sj-refundsinfo{
                        width:100%;
                        clear:both;
                    display: block;
                }
                table.sj-carttable tbody tr:nth-child(6){border:0;}
                table.sj-carttablevtwo tbody tr:nth-child(6) td{padding: 20px 20px 0px;}
              `
                const d = new Printd()
                d.print(document.getElementById('printable_area'), cssText)
            }
        }
    });
}
if (document.getElementById("customer_invoice")) {
    new Vue({
        el: '#customer_invoice',
        mounted: function () {
            // $('.print-window').click(function() {
            //     window.print();
            // });
        },
        data: { },
        methods: {
            print: function () {
                const cssText = `
                .sj-transactionhold{
                    float: left;
                    width: 100%;
                }
                .sj-borderheadingvtwo a{font-size: 18px;}
                .sj-transactiondetails{
                    float: left;
                    width: 100%;
                    list-style:none;
                    margin-bottom:20px;
                    line-height: 28px;
                }
                .sj-transactiondetails li{
                    float: left;
                    width: 100%;
                    margin-bottom: 10px;
                    line-height: inherit;
                    list-style-type:none;
                }
                .sj-transactiondetails li:last-child{margin: 0;}
                .sj-transactiondetails li span{
                    font-size: 16px;
                    line-height: inherit;
                }
                .sj-transactiondetails li span.sj-grossamount {float: right;}
                .sj-transactiondetails li span em{
                    font-weight:500;
                    font-style:normal;
                    line-height: inherit;
                }
                .sj-transactionid{
                    margin-left:80px;
                    padding-left:10px;
                    border-left:2px solid #ddd;
                }
                .sj-grossamountusd{font-size: 24px !important;}
                .sj-paymentstatus{
                    color: #21ce93;
                    padding:3px 10px;
                    margin-left:10px;
                    font-size: 14px !important;
                    text-transform: uppercase;
                    border:1px solid #21ce93;
                }
                .sj-createtransactionhold{
                    float: left;
                    width: 100%;
                }
                .sj-createtransactionholdvtwo{
                    padding:0 20px;
                }
                .sj-createtransactionheading{
                    float: left;
                    width: 100%;
                    padding-bottom:15px;
                    border-bottom:1px solid #ddd;
                }
                .sj-createtransactionheading span{
                    display: block;
                    color: #1070c4;
                    font-size: 16px;
                    line-height: 20px;
                }
                .sj-createtransactioncontent{
                    float: left;
                    width: 100%;
                    padding:27px 0;
                    border-bottom: 1px solid #ddd;
                }
                .sj-createtransactioncontent a{
                    padding:0 10px;
                    color: #1070c4;
                    font-size: 14px;
                    line-height: 16px;
                    display: inline-block;
                    vertical-align: middle;
                    border-left:1px solid #ddd;
                }
                .sj-createtransactioncontent a:first-child{
                    border-left:0;
                    padding-left:0;
                }
                .sj-addresshold{
                    float: left;
                    width: 100%;
                    padding:18px 0;
                }
                .sj-addresshold h4{
                    margin: 0;
                    display: block;
                    font-size: 16px;
                    font-weight: 500;
                }
                table.sj-carttable{ margin-bottom:0;}
                table.sj-carttable thead{
                    border:0;
                    font-size:14px;
                    line-height:18px;
                    background: #f5f7fa;
                }
                table.sj-carttable thead tr th{
                    border:0;
                    text-align:left;
                    font-weight: 500;
                    font-weight:normal;
                    padding:20px 4px 20px 160px;
                    font:500 16px/18px 'Montserrat', Arial, Helvetica, sans-serif;
                }
                table.sj-carttable thead tr th + th{
                    text-align:center;
                    padding:20px 4px;
                }
                table.sj-carttable tbody td{
                    width:50%;
                    border:0;
                    font-size:16px;
                    text-align:left;
                    line-height: 20px;
                    display:table-cell;
                    vertical-align:middle;
                    padding:10px 4px 10px 0;
                }
                table.sj-carttable tbody td span,
                table.sj-carttable tbody td img{
                    display:inline-block;
                    vertical-align:middle;
                }
                table.sj-carttable tbody td em{
                    margin: 0;
                    font-size: 16px;
                    line-height: 16px;
                    font-style: normal;
                    vertical-align: middle;
                    display: inline-block;
                }
                table.sj-carttable > thead > tr > th{
                    padding: 6px 20px;
                    width: 25%;
                }
                table.sj-carttable > thead:first-child > tr:first-child > th{
                    border:0;
                    width: 25%;
                    padding: 6px 20px;
                }
                table.sj-carttable tbody td > em{
                    display: block;
                    text-align: center;
                }
                table.sj-carttable tbody td img{
                    width: 116px;
                    height: 116px;
                    margin-right:20px;
                    border-radius:10px;
                }
                table.sj-carttable tbody td + td{
                    width:15%;
                    text-align:center;
                }
                table.sj-carttable tbody td:last-child{
                    width:10%;
                    text-align:right;
                    padding:20px 20px 20px 4px;
                }
                table.sj-carttable tbody td .btn-delete-item{
                    float:right;
                    font-size:24px;
                }
                table.sj-carttable tbody td .btn-delete-item a{color: #fe6767}
                table.sj-carttable tbody td .quantity-sapn{
                    padding:0;
                    width:80px;
                    position:relative;
                    border-radius: 10px;
                    border: 1px solid #e7e7e7;
                }
                table.sj-carttable tbody td .quantity-sapn input[type="text"]{
                    width: 100%;
                    height: 42px;
                    padding: 0 15px;
                    border-radius: 0;
                    box-shadow: none;
                    background: none;
                    line-height: 42px;
                }
                table.sj-carttable tbody td .quantity-sapn input{border:0;}
                table.sj-carttable tbody td .quantity-sapn em{
                    width:10px;
                    display:block;
                    position:absolute;
                    right:10px;
                    cursor:pointer;
                }
                table.sj-carttable tbody td .quantity-sapn em.fa-caret-up{top:8px;}
                table.sj-carttable tbody td .quantity-sapn em.fa-caret-down{ bottom:8px;}
                table.sj-carttable tfoot tr td{ width:50%;}
                table.sj-carttable tbody tr{border-bottom: 1px solid #ddd;}
                table.sj-carttable tbody tr:last-child{border-bottom:0; }
                table.sj-carttablevtwo tbody td > em{
                    color: #636c77;
                    font-weight:500;
                    text-align: left;
                    display: inline-block;
                }
                table.sj-carttablevtwo tbody td > span{
                    float: right;
                }
                table.sj-carttablevtwo tbody td{padding:20px;}

                .sj-refundscontent{
                    float: left;
                    width: 100%;
                }
                .sj-refundsdetails{
                    float: left;
                    width: 100%;
                    list-style:none;
                }
                .sj-refundsdetails li{
                    float: left;
                    width: 100%;
                    padding:15px 0;
                    list-style-type:none;
                }
                .sj-refundsdetails li + li{border-top: 1px solid #ddd;}
                .sj-refundsdetails li strong{
                    width: 300px;
                    float:left;
                }
                .sj-refundsdetails li .sj-rightarea{float: left;}
                .sj-refundsdetails li .sj-rightarea span{
                    display: block;
                }
                .sj-refundsdetails li .sj-rightarea em{
                    font-weight:500;
                    font-style: normal;
                }
                .sj-refundsdetails li:nth-child(3){
                    border:0;
                    padding-top:0;
                }
                .sj-refundsinfo{
                        width:100%;
                        clear:both;
                    display: block;
                }
                table.sj-carttable tbody tr:nth-child(6){border:0;}
                table.sj-carttablevtwo tbody tr:nth-child(6) td{padding: 20px 20px 0px;}
              `
                const d = new Printd()
                d.print(document.getElementById('customer_printable_area'), cssText)
            }
        }
    });
}
if (document.getElementById("email_settings_holder")) {
    new Vue({
        el: '#email_settings_holder',
        mounted: function () {
            if (document.getElementsByClassName("toast-holder") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
    });
}
if (document.getElementById("payment_settings")) {
    new Vue({
        el: '#payment_settings',
        mounted: function () {
            if (document.getElementsByClassName("toast-holder") != null) {
                flashVue.$emit('showFlashMessage');
            }
        },
    });
}
