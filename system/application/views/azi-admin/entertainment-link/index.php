<div class="container">
    <div class="administrator-bussinesspost">
        <h2 class="tit">Đề xuất</h2>

        <form method="GET" action="<?php echo base_url() .'azi-admin/entertainment-link/search' ?>">
            <div class="search">
                <div class="search-input">
                    <img src="/templates/home/styles/images/svg/search.svg" alt="">
                    <input type="text" name="name" class="form-control" placeholder="Nhập từ khóa"
                           value="<?= !empty($params['name']) ? $params['name'] : '' ?>">
                </div>
                <div class="search-category">
                    <select name="category" id="" class="form-control">
                        <option value="">---Theo category---</option>
                        <?php foreach ($category as $cat): ?>
                            <option value="<?= $cat->id ?>"
                                <?= !empty($params['category']) && $params['category'] == $cat->id ? "selected" : '' ?> >
                                <?= $cat->name ?>
                            </option>
                            <?php if (!empty($cat->children)): ?>
                                <?php foreach ($cat->children as $child): ?>
                                <option value="<?= $child->id ?>"
                                    <?= !empty($params['category']) && $params['category'] == $child->id ? "selected" : '' ?>>
                                    -----<?= $child->name ?>
                                </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="search-state">
                    <select name="status" id="" class="form-control">
                        <option value="">---Theo status---</option>
                        <option value="1"
                            <?= is_numeric($params['status']) && $params['status'] == 1 ? "selected" : '' ?>>
                            Kích hoạt
                        </option>
                        <option value="0"
                            <?= is_numeric($params['status']) && $params['status'] == 0 ? "selected" : '' ?>>
                            Không kích hoạt
                        </option>
                    </select>
                </div>
                <div class="search-sort-order">
                    <select name="sort_order" id="" class="form-control">
                        <option value="">---Theo sort order---</option>
                        <option value="2"
                            <?= is_numeric($params['sort_order']) && $params['sort_order'] == 2 ? "selected" : '' ?>>
                            Cao đến thấp
                        </option>
                        <option value="1"
                            <?= is_numeric($params['sort_order']) && $params['sort_order'] == 1 ? "selected" : '' ?>>
                            Thấp đến cao
                        </option>
                    </select>
                </div>
                <div class="search-date">
                    <div class="from">
                        <input type="text" name="created_date[from]" class="form-control datepicker" placeholder="Chọn ngày">
                    </div>
                    <p class="txt">Đến</p>
                    <div class="to">
                        <input type="text" name="created_date[to]" class="form-control datepicker" placeholder="Chọn ngày">
                    </div>
                </div>
<!--                <a class="btn-search">Tìm kiếm</a>-->
                <input type="submit" class="btn-search" value="Tìm kiếm">
            </div>
        </form>

        <div class="text-center">
            <a class="btn-addlink" href="<?php echo base_url() .'azi-admin/entertainment-link/add-link/' ?>"><img
                        src="/templates/home/styles/images/svg/themloitat_white.svg" class="mr10" width="20">Thêm liên
                kết đề xuất</a>
        </div>
        <div class="bussinesspost-table">
<!--            <div class="sm">-->
<!--                <div class="selectArea">-->
<!--                    <label class="checkbox-style">-->
<!--                        <input class="selectAll" type="checkbox" value="aaa"><span></span>-->
<!--                    </label>-->
<!--                    <p class="sm mr10">Select All</p>-->
<!--                    <div class="selectArea-selecttype">-->
<!--                        <p data-toggle="dropdown" class="selectArea-selecttype-icon">-->
<!--                            <i class="fa fa-caret-down" aria-hidden="true"></i>-->
<!--                        </p>-->
<!--                        <ul class="dropdown-menu selectArea-selecttype-list">-->
<!--                            <li><a href="#" >Đổi trạng thái</a></li>-->
<!--                            <li><a href="#" >Xóa</a></li>-->
<!--                        </ul>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
            <table>
                <tr class="sm-none">
                    <th>
                        <div class="selectArea">
                            <label class="checkbox-style">
                                <input class="selectAll" type="checkbox" value="aaa"><span></span>
                            </label>
                            <div class="selectArea-selecttype">
                                <p data-toggle="dropdown" class="selectArea-selecttype-icon">
                                    <i class="fa fa-caret-down" aria-hidden="true"></i>
                                </p>
                                <ul class="dropdown-menu selectArea-selecttype-list">
                                    <li><a href="#" id="multi-change-status">Đổi trạng thái</a></li>
                                    <li><a href="#" id="multi-delete">Xóa</a></li>
                                </ul>
                            </div>
                        </div>
                    </th>
                    <th>ID</th>
                    <th>Ảnh/video</th>
                    <th>Liên kết</th>
                    <th>Người đăng</th>
                    <th>Sắp xếp</th>
                    <th>Chuyên mục</th>
                    <th>Ngày đăng</th>
                    <th>Kích hoạt</th>
                    <th>Chỉnh sửa</th>
                    <th>Xóa</th>
                </tr>
                <?php if (!empty($list = $response->data)): ?>
                    <?php foreach ($list as $link): ?>
                        <tr>
                            <td class="checkbox">
                                <label class="checkbox-style">
                                    <input id="mce-group[19]-19-0" class="list_id" type="checkbox" name="ids[]" value="<?= $link->id ?>">
                                    <span></span>
                                </label>
                            </td>
                            <td class="id sm-none"><?= $link->id ?></td>
                            <td class="sm-none">
                                <?php
                                $image = "/templates/home/styles/images/default/error_image_400x400.jpg";
                                if (!empty($link->image)){
                                    $image = URL_CDN2_CUSTOM_LINK.$link->image;
                                } elseif (!empty($link->image_default)) {
                                    $image = $link->image_default;
                                }

                                ?>
                                <img src="<?= $image ?>" class="image">
                            </td>
                            <td class="title">
                                <div class="text">
                                    <?= $link->title ?>
                                </div>
<!--                                <div class="sm">-->
<!--                                    <div class="small-txt">-->
<!--                                        <span>tên người đăng</span>-->
<!--                                        <span>Thể thao</span>-->
<!--                                        <span>17/07/2019</span>-->
<!--                                    </div>-->
<!--                                    <div class="small-btn">-->
<!--                                        <button class="btn" href=""><img src="/templates/home/styles/images/svg/kichhoat.svg"-->
<!--                                                                         class="mr05" alt="">Kích hoạt-->
<!--                                        </button>-->
<!--                                        <button class="btn" data-target="#displayInformation" data-toggle="modal">Sửa</button>-->
<!--                                        <button class="btn">Xóa</button>-->
<!--                                    </div>-->
<!--                                </div>-->
                            </td>
                            <td class="sm-none"><?= $link->type_user == "admin" ? "Admin" : $link->user->use_fullname ?></td>
                            <td class="sm-none"><?= $link->sort_order ?></td>
                            <td class="sm-none"><?= !empty($link->category) ? $link->category->name : '' ?></td>
                            <td class="sm-none"><span class="nowrap"><?= $link->created_at ?></span></td>
                            <td class="sm-none">
                                <?php
                                $status = "/templates/home/styles/images/svg/check_pink.svg";
                                if ($link->status == 0) {
                                    $status = "/templates/home/styles/images/svg/close_gray.svg";
                                }
                                ?>
                                <a href="<?php echo base_url() .'azi-admin/entertainment-link/change-status/'.$link->id ?>">
                                    <img src="<?= $status ?>" alt="">
                                </a>
                            </td>
                            <td class="sm-none">
                                <a href="#" class="edit-link" data-id="<?= $link->id ?>">Sửa</a>
                            </td>
                            <td class="sm-none">
                                <a class="delete-link" href="<?php echo base_url() .'azi-admin/entertainment-link/delete/'.$link->id ?>">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="10">Danh sách rỗng</td></tr>
                <?php endif; ?>
            </table>
        </div>
        <?php if (!empty($list)): ?>
            <?php echo $pagination ? $pagination : ''; ?>
<!--        <nav aria-label="Page navigation example">-->
<!--            <ul class="pagination pagination-center-style justify-content-center">-->
<!--                <li class="page-item">-->
<!--                    <a class="page-link" href="#" aria-label="Previous">-->
<!--                        <span aria-hidden="true"><</span>-->
<!--                        <span class="sr-only">Previous</span>-->
<!--                    </a>-->
<!--                </li>-->
<!--                <li class="page-item active"><a class="page-link" href="#">1</a></li>-->
<!--                <li class="page-item"><a class="page-link" href="#">2</a></li>-->
<!--                <li class="page-item"><a class="page-link" href="#">3</a></li>-->
<!--                <li class="page-item">-->
<!--                    <a class="page-link" href="#" aria-label="Next">-->
<!--                        <span aria-hidden="true">></span>-->
<!--                        <span class="sr-only">Next</span>-->
<!--                    </a>-->
<!--                </li>-->
<!--            </ul>-->
<!--        </nav>-->
        <?php endif; ?>
    </div>
</div>

<?php $this->load->view('azi-admin/entertainment-link/element/popup'); ?>

<script type="text/javascript">
    $('.datepicker').datetimepicker();
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();

        $('body').on('click', '.delete-link', function (e) {
            var msgConfirm = confirm('Bạn có chắc chắn xóa liên kết này ?');
            if (msgConfirm === false) {
                e.preventDefault();
            }
        });

        $('body').on('click', '#multi-change-status', function (e) {
            var list_id = [];
            $.each($('.list_id:checked'), function(){
                list_id.push($(this).val());
            });

            if (list_id.length > 0) {
                $.ajax({
                    url: '/azi-admin/entertainment-link/multi-change-status',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        ids: list_id
                    }
                }).done(function(response) {
                    if (response.url_back) {
                        window.location.href = response.url_back
                    }
                });
            }
        });

        $('body').on('click', '#multi-delete', function (e) {
            var list_id = [];
            $.each($('.list_id:checked'), function(){
                list_id.push($(this).val());
            });

            if (list_id.length > 0) {
                $.ajax({
                    url: '/azi-admin/entertainment-link/multi-delete',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        ids: list_id
                    }
                }).done(function(response) {
                    if (response.url_back) {
                        window.location.href = response.url_back
                    }
                });
            }
        });
    });
    $(".selectAll").click(function(){
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    });
</script>
<?php //$this->load->view('home/common/modal-mess'); ?>