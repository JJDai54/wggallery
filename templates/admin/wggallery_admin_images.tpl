<!-- Header -->
<{include file='db:wggallery_admin_header.tpl'}>
<{if !empty($form)}>
	<{$form}>
<{/if}>
<{if !empty($error)}>
	<div class='errorMsg'><strong><{$error}></strong></div>
<{/if}>
<{if $images_list|default:''}>
    <{if $images_approve|default:''}>
        <table class='table table-bordered'>
            <thead>
                <tr class='head'>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_ALBUM}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_ID}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE}></th>
                    <th class='center'>
                        <{$smarty.const._CO_WGGALLERY_IMAGE_TITLE}><br>
                        <{$smarty.const._CO_WGGALLERY_IMAGE_NAME}><br>
                        <{$smarty.const._CO_WGGALLERY_IMAGE_MIMETYPE}>
                    </th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_SIZE}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_RESX}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_RESY}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_WEIGHT}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_IP}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_DATE}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_SUBMITTER}></th>
                    <th class='center width5'><{$smarty.const._CO_WGGALLERY_FORM_ACTION}></th>
                </tr>
            </thead>
            <{if $images_count|default:''}>
                <tbody>
                    <{foreach item=image from=$images_list}>
                        <tr class="<{cycle values='odd, even'}>">
                            <td class='center'><{$image.alb_name}></td>
                            <td class='center'><{$image.id}></td>
                            <td class='left'>
                                <img src='<{$image.thumb}>' style='max-height:50px' alt='<{$image.name}>'><br>
                                <{$image.title}><br>
                                <{$image.name}>
                            </td>
                            <td class='center'><{$image.mimetype}></td>
                            <td class='center'><{$image.size}></td>
                            <td class='center'><{$image.resx}></td>
                            <td class='center'><{$image.resy}></td>
                            <td class='center'><{$image.weight}></td>
                            <td class='center'><{$image.ip}></td>
                            <td class='center'><{$image.date}></td>
                            <td class='center'><{$image.submitter}></td>
                            <td class='center  width10'>
                                <{if $image.state|default:'' == 0}>
                                    <a href='images.php?op=change_state&amp;img_state=1&amp;img_id=<{$image.id}>&amp;alb_id=<{$image.albid}>' title='<{$smarty.const._CO_WGGALLERY_STATE_ONLINE}>'>
                                        <img src='<{$wggallery_icon_url_16}>state1.png' alt='<{$smarty.const._CO_WGGALLERY_STATE_ONLINE}>'></a>
                                <{/if}>
                                <{if $image.state|default:'' == 1}>
                                    <a href='images.php?op=change_state&amp;img_state=0&amp;img_id=<{$image.id}>&amp;alb_id=<{$image.albid}>' title='<{$smarty.const._CO_WGGALLERY_STATE_OFFLINE}>'>
                                        <img src='<{$wggallery_icon_url_16}>state0.png' alt='<{$smarty.const._CO_WGGALLERY_STATE_OFFLINE}>'></a>
                                <{/if}>
                                <{if $image.state|default:'' == 2}>
                                    <a href='images.php?op=change_state&amp;img_state=1&amp;img_id=<{$image.id}>&amp;alb_id=<{$image.albid}>' title='<{$smarty.const._CO_WGGALLERY_STATE_ONLINE}>'>
                                        <img src='<{$wggallery_icon_url_16}>state1.png' alt='<{$smarty.const._CO_WGGALLERY_STATE_ONLINE}>'></a>
                                    <a href='images.php?op=change_state&amp;img_state=0&amp;img_id=<{$image.id}>&amp;alb_id=<{$image.albid}>' title='<{$smarty.const._CO_WGGALLERY_STATE_OFFLINE}>'>
                                        <img src='<{$wggallery_icon_url_16}>state0.png' alt='<{$smarty.const._CO_WGGALLERY_STATE_OFFLINE}>'></a>
                                <{/if}>
                                <a href='<{$wggallery_url}>/admin/images.php?op=edit&amp;img_id=<{$image.id}>&amp;alb_id=<{$image.albid}>' title='<{$smarty.const._EDIT}>'>
                                    <img src='<{xoModuleIcons16 'edit.png'}>' alt='images'></a>
                                <a href='<{$wggallery_url}>/admin/images.php?op=delete&amp;img_id=<{$image.id}>&amp;alb_id=<{$image.albid}>' title='<{$smarty.const._DELETE}>'>
                                    <img src='<{xoModuleIcons16 'delete.png'}>' alt='images'></a>
                            </td>
                        </tr>
                    <{/foreach}>
                </tbody>
            <{/if}>
        </table>
    <{else}>
        <{assign var="fldImg" value="blue"}>

        <table class='table table-bordered'>
            <thead>
                <tr class='head'>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_ID}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE}></th>
                    <th class='center'>
                        <{$smarty.const._CO_WGGALLERY_IMAGE_TITLE}><br>
                        <{$smarty.const._CO_WGGALLERY_IMAGE_NAME}><br>
                        <{$smarty.const._CO_WGGALLERY_IMAGE_NAMELARGE}><br>
                        <{$smarty.const._CO_WGGALLERY_IMAGE_NAMEORIG}>
                    </th>
                    <th class='center'>
                        <{$smarty.const._CO_WGGALLERY_WEIGHT}>
                        <img src="<{$wggallery_icon_url_16}>/arrows/blank-16.png" title="">                    
                        <a href='images.php?op=update_weight_by_fields&sort=img_weight&orderby=ASC<{$context}>' title='<{$smarty.const._AM_WGGALLERY_ALPHA}>'>
                            <img src='<{$wggallery_icon_url_16}>alpha_asc.png' alt='<{$smarty.const._AM_WGGALLERY_ALPHA}>'></a>

                    </th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_STATE}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_MIMETYPE}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_SIZE}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_RESX}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_RESY}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_DOWNLOADS}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_RATINGLIKES}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_VOTES}></th>
                    <{if $use_categories|default:''}><th class='center'><{$smarty.const._CO_WGGALLERY_CATS}></th><{/if}>
                    <{if $use_tags|default:''}><th class='center'><{$smarty.const._CO_WGGALLERY_TAGS}></th><{/if}>
                    <{* <th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_IP}></th> *}>
                    <{if $show_exif|default:''}><th class='center'><{$smarty.const._CO_WGGALLERY_IMAGE_EXIF}></th><{/if}>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_DATE}></th>
                    <th class='center'><{$smarty.const._CO_WGGALLERY_SUBMITTER}></th>
                    <th class='center width5'><{$smarty.const._CO_WGGALLERY_FORM_ACTION}></th>
                </tr>
            </thead>
            <{if $images_count|default:''}>
                <tbody>
                    <{foreach item=image from=$images_list name=collImages}>
                        <tr class="<{cycle values='odd, even'}>">
                            <td class='center'><{$image.id}></td>
                            <td class='center'><img src='<{$image.thumb}>' style='max-height:50px' alt='<{$image.name}>'></td>
                            <td class='left'>
                                <{$image.title}><br>
                                <{$image.name}><br>
                                <{$image.namelarge}><br>
                                <{$image.nameorig}>
                            </td>
                <{* ---------------- Arrows Weight -------------------- *}>
                <td class="center width20" <{$styleParent}> >
                    <{if $smarty.foreach.collImages.first}>
                      <img src="<{$wggallery_icon_url_16}>/arrows/<{$fldImg}>/first-0.png" title="<{$smarty.const._AM_WGGALLERY_FIRST}>">
                      <img src="<{$wggallery_icon_url_16}>/arrows/<{$fldImg}>/up-0.png" title="<{$smarty.const._AM_WGGALLERY_UP}>">
                    <{else}>
                      <a href="images.php?op=update_weight&imgId=<{$image.id}>&action=first&weight=<{$image.weight}><{$context}>">
                      <img src="<{$wggallery_icon_url_16}>/arrows/<{$fldImg}>/first-1.png" title="<{$smarty.const._AM_WGGALLERY_FIRST}>">
                      </a>
                    
                      <a href="images.php?op=update_weight&imgId=<{$image.id}>&action=up&weight=<{$image.weight}><{$context}>">
                      <img src="<{$wggallery_icon_url_16}>/arrows/<{$fldImg}>/up-1.png" title="<{$smarty.const._AM_WGGALLERY_UP}>">
                      </a>
                    <{/if}>
                 
                    <{* ----------------------------------- *}>
                    <img src="<{$wggallery_icon_url_16}>/arrows/blank-08.png" title="">
                    <{$image.weight}>
                    <img src="<{$wggallery_icon_url_16}>/arrows/blank-08.png" title="">
                    <{* ----------------------------------- *}>
                 
                    <{if $smarty.foreach.collImages.last}>
                      <img src="<{$wggallery_icon_url_16}>/arrows/<{$fldImg}>/down-0.png" title="<{$smarty.const._AM_WGGALLERY_DOWN}>">
                      <img src="<{$wggallery_icon_url_16}>/arrows/<{$fldImg}>/last-0.png" title="<{$smarty.const._AM_WGGALLERY_LAST}>">
                    <{else}>
                    
                    <a href="images.php?op=update_weight&imgId=<{$image.id}>&action=down&weight=<{$image.weight}><{$context}>">
                      <img src="<{$wggallery_icon_url_16}>/arrows/<{$fldImg}>/down-1.png" title="<{$smarty.const._AM_WGGALLERY_DOWN}>">
                      </a>
                 
                    <a href="images.php?op=update_weight&imgId=<{$image.id}>&action=last&weight=<{$image.weight}><{$context}>">
                      <img src="<{$wggallery_icon_url_16}>/arrows/<{$fldImg}>/last-1.png" title="<{$smarty.const._AM_WGGALLERY_LAST}>">
                      </a>
                    </td>
                    <{/if}>
                <{* ---------------- /Arrows weight -------------------- *}>

                            <td class='center'>
                                <{* JJDai : transfet de la du changement d'état dans la colonne etat *}>
                                <{if $image.state|default:'' == 1}>
                                    <a href='images.php?op=change_state&amp;img_state=0&amp;img_id=<{$image.id}>&amp;alb_id=<{$image.albid}>' title='<{$smarty.const._CO_WGGALLERY_STATE_OFFLINE}>'>
                                        <img src='<{$wggallery_icon_url_16}>state1.png' alt='<{$smarty.const._CO_WGGALLERY_STATE_OFFLINE}>'></a>
                                <{elseif $image.state|default:'' == 2}>
                                    <a href='images.php?op=change_state&amp;img_state=1&amp;img_id=<{$image.id}>&amp;alb_id=<{$image.albid}>' title='<{$smarty.const._CO_WGGALLERY_STATE_ONLINE}>'>
                                        <img src='<{$wggallery_icon_url_16}>state1.png' alt='<{$smarty.const._CO_WGGALLERY_STATE_ONLINE}>'></a>
                                    <a href='images.php?op=change_state&amp;img_state=0&amp;img_id=<{$image.id}>&amp;alb_id=<{$image.albid}>' title='<{$smarty.const._CO_WGGALLERY_STATE_OFFLINE}>'>
                                        <img src='<{$wggallery_icon_url_16}>state2.png' alt='<{$smarty.const._CO_WGGALLERY_STATE_OFFLINE}>'></a>
                                <{else}>
                                    <a href='images.php?op=change_state&amp;img_state=1&amp;img_id=<{$image.id}>&amp;alb_id=<{$image.albid}>' title='<{$smarty.const._CO_WGGALLERY_STATE_ONLINE}>'>
                                        <img src='<{$wggallery_icon_url_16}>state0.png' alt='<{$smarty.const._CO_WGGALLERY_STATE_ONLINE}>'></a>
                                <{/if}>
                            </td>
                            <td class='center'><{$image.mimetype}></td>
                            <td class='center'><{$image.size}></td>
                            <td class='center'><{$image.resx}></td>
                            <td class='center'><{$image.resy}></td>
                            <td class='center'><{$image.downloads}></td>
                            <td class='center'><{$image.ratinglikes}></td>
                            <td class='center'><{$image.votes}></td>
                            <{if $use_categories|default:''}><td class='center'><{$image.cats_list}></td><{/if}>
                            <{if $use_tags|default:''}><td class='center'><{$image.tags}></td><{/if}>
                            <{* <td class='center'><{$image.ip}></td> *}>
                            <{if $show_exif|default:''}><td class='left'><{$image.exif_short}></td><{/if}>
                            <td class='center'><{$image.date}></td>
                            <td class='center'><{$image.submitter}></td>
                            <td class='center  width10'>
                                <a href='<{$wggallery_url}>/admin/images.php?op=edit&amp;img_id=<{$image.id}>&amp;alb_id=<{$image.albid}>' title='<{$smarty.const._EDIT}>'>
                                    <img src='<{xoModuleIcons16}>/edit.png' alt='images'></a>
                                <a href='<{$wggallery_url}>/admin/images.php?op=delete&amp;img_id=<{$image.id}>&amp;alb_id=<{$image.albid}>' title='<{$smarty.const._DELETE}>'>
                                    <img src='<{xoModuleIcons16}>/delete.png' alt='images'></a>
                            </td>
                        </tr>
                    <{/foreach}>
                </tbody>
            <{/if}>
        </table>
    <{/if}>
	<div class='clear'>&nbsp;</div>
	<{if !empty($pagenav)}>
		<div class='xo-pagenav floatright'><{$pagenav}></div>
		<div class='clear spacer'></div>
	<{/if}>
<{/if}>
<br>
<!-- Footer --><{include file='db:wggallery_admin_footer.tpl'}>
