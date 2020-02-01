listPost = document.getElementById('allPost')
let countGetPost = 1
let getPostActive = true 

window.onscroll = function () {
    if (offset < window.scrollY && getPostActive) {
        offset += offset

        axios.get(`${mainPath}/post/?id=${id_user}&end_cursor=${end_cursor}&post=get_post`)
        .then(function (response){
            response = response['data']
            console.log(response)
            if (response['success']) {
                console.log(JSON.parse(response['result']))
                response = JSON.parse(response['result'])['data']['user']
                posts = response['edge_owner_to_timeline_media']['edges']
                end_cursor = response['edge_owner_to_timeline_media']['page_info']['end_cursor']
                if (end_cursor != null) {
                    end_cursor = end_cursor.replace('==', '')
                } else {
                    getPostActive = false
                }

                countGetPost += 1
                posts.forEach((value, key) => {
                    let post = `<div class="profile__photo ${key == 8 ? `offset${countGetPost}` : ''}">
                                <div style="background-image: url('${value['node']['display_url']}'); background-size: <?=$width?>%; height: 290px; width: 290px; background-position:center;">&nbsp;</div>
                                <div class="profile__photo-overlay">
                                    <span class="overlay__item">
                                        <i class="fa fa-heart"></i>
                                        ${value['node']['edge_media_preview_like']['count']}
                                    </span>
                                    <span class="overlay__item">
                                        <i class="fa fa-comment"></i>
                                        ${value['node']['edge_media_to_comment']['count']}
                                    </span>
                                </div>
                            </div>`
                    
                    listPost.innerHTML = listPost.innerHTML + post
                })

                offset -= offset
                offset += document.querySelector(`.offset${countGetPost}`).offsetTop
            } else {
                console.log(response)
            }
        })


    }
}