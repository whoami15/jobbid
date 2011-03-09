<?php
class TOOLBAR_tourdulich {
//Hàm này sẽ hiển thị các nút thêm, xóa, sửa khi chúng ta load component lên.
    function _tourdulich() {
        JToolbarHelper::title( JText::_('Quản lý component'), 'generic.png' );
        JToolbarHelper::deleteList();
        JToolbarHelper::editListX();
        JToolbarHelper::addNewX();
    }
//hàm này sẽ hiển thị các nút lưu, đóng,... khi ta chọn một dòng để sửa.
    function _EDIT_TOURDULICH() {
        JToolBarHelper::title(   JText::_( 'Sửa thông tin ' ).': <small><small>[ '.JText::_( 'sửa dữ liệu component' ).' ]</small></small>' );
        JToolBarHelper::apply();
        JToolBarHelper::custom( 'save2new', 'new.png', 'new_f2.png', 'Save &amp; New', false );
        JToolBarHelper::save();
        JToolBarHelper::cancel( 'cancel', 'Close' );
    }
//hàm này sẽ tạo ra các button khi ta tạo một thông tin mới trong component
    function _NEW_TOURDULICH() {
        JToolBarHelper::title(   JText::_( 'Tạo Mới' ).': <small><small>[ '.JText::_( 'dữ liệu component' ).' ]</small></small>' );
        JToolBarHelper::custom('save2new','new.png','new_f2.png', 'Save &amp; New', false );
        JToolBarHelper::save();
        JToolBarHelper::cancel( 'cancel', 'Close' );
    }
}
class TOOLBAR_Danhmuc {
//Hàm này sẽ hiển thị các nút thêm, xóa, sửa khi chúng ta load component lên.
    function _Danhmuc() {
        JToolbarHelper::title( JText::_('Quản lý component'), 'generic.png' );
        JToolbarHelper::deleteList();
        JToolbarHelper::editListX();
        JToolbarHelper::addNewX();
    }
//hàm này sẽ hiển thị các nút lưu, đóng,... khi ta chọn một dòng để sửa.
    function _EDIT_Danhmuc() {
        JToolBarHelper::title(   JText::_( 'Sửa thông tin ' ).': <small><small>[ '.JText::_( 'sửa dữ liệu component' ).' ]</small></small>' );
        JToolBarHelper::apply();
        JToolBarHelper::custom( 'save2new', 'new.png', 'new_f2.png', 'Save &amp; New', false );
        JToolBarHelper::save();
        JToolBarHelper::cancel( 'cancel', 'Close' );
    }
//hàm này sẽ tạo ra các button khi ta tạo một thông tin mới trong component
    function _NEW_Danhmuc() {
        JToolBarHelper::title(   JText::_( 'Tạo Mới' ).': <small><small>[ '.JText::_( 'dữ liệu component' ).' ]</small></small>' );
        JToolBarHelper::custom('save2new','new.png','new_f2.png', 'Save &amp; New', false );
        JToolBarHelper::save();
        JToolBarHelper::cancel( 'cancel', 'Close' );
    }
}
class TOOLBAR_Noidung {
//Hàm này sẽ hiển thị các nút thêm, xóa, sửa khi chúng ta load component lên.
    function _Noidung() {
        JToolbarHelper::title( JText::_('Quản lý nội dung Tour'), 'generic.png' );
        JToolbarHelper::deleteList();
        JToolbarHelper::editListX();
        JToolBarHelper::custom( 'add', 'new.png', 'new_f2.png', 'Thêm nội dung', false );
        JToolBarHelper::cancel( 'close', 'Đóng' );
    }
//hàm này sẽ hiển thị các nút lưu, đóng,... khi ta chọn một dòng để sửa.
    function _EDIT_Noidung() {
        JToolBarHelper::title(   JText::_( 'Sửa thông tin ' ).': <small><small>[ '.JText::_( 'Sửa dữ liệu nội dung' ).' ]</small></small>' );
        JToolBarHelper::apply();
        JToolBarHelper::custom( 'save2new', 'new.png', 'new_f2.png', 'Save &amp; New', false );
        JToolBarHelper::save();
        JToolBarHelper::cancel( 'cancel', 'Close' );
    }
//hàm này sẽ tạo ra các button khi ta tạo một thông tin mới trong component
    function _NEW_Noidung() {
        JToolBarHelper::title(   JText::_( 'Tạo Mới' ).': <small><small>[ '.JText::_( 'dữ liệu component' ).' ]</small></small>' );
        JToolBarHelper::custom('save2new','new.png','new_f2.png', 'Lưu & Tạo mới', false );
        JToolBarHelper::custom('save','save.png','save_f2.png', 'Lưu', false );
        JToolBarHelper::cancel( 'cancel', 'Hủy' );
    }
}
