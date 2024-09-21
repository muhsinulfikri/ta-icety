var readMoreText = document.querySelector('.readmore-text')
var readMoreBtn = document.querySelector('.readmore-btn')
if(readMoreText){
    if(readMoreText.clientWidth < readMoreText.scrollWidth || readMoreText.clientHeight < readMoreText.scrollHeight){
        if(readMoreBtn){
            readMoreBtn.addEventListener('click',function(){
                readMoreBtn.parentElement.classList.toggle('showContent');
                readMoreBtn.remove()
            })
        }
        
    }else{
        if(readMoreBtn){
            readMoreBtn.remove()
        }
    }
}
if(readMoreBtn){
    readMoreBtn.addEventListener('click',function(){
        console.log(readMoreText.clientWidth < readMoreText.scrollWidth || readMoreText.clientHeight < readMoreText.scrollHeight)
        // readMoreBtn.parentElement.classList.toggle('showContent');
        // readMoreBtn.remove()
    })
}

const myCollapsible = document.getElementById('collapseExample')
if(myCollapsible){
    myCollapsible.addEventListener('hide.bs.collapse', event => {
        document.querySelector(".collapseExample .icon-bi").className = 'icon-bi bi-plus-lg';
    })
    myCollapsible.addEventListener('show.bs.collapse', event => {
        document.querySelector(".collapseExample .icon-bi").className = 'icon-bi bi-dash-lg';
    })
}

const myCollapsible2 = document.getElementById('collapseExample2')
if(myCollapsible2){
    myCollapsible2.addEventListener('hide.bs.collapse', event => {
        document.querySelector(".collapseExample2 .icon-bi").className = 'icon-bi bi-plus-lg';
    })
    myCollapsible2.addEventListener('show.bs.collapse', event => {
        document.querySelector(".collapseExample2 .icon-bi").className = 'icon-bi bi-dash-lg';
    })
}

const myCollapsible3 = document.getElementById('collapseExample3')
if(myCollapsible3){
    myCollapsible3.addEventListener('hide.bs.collapse', event => {
        document.querySelector(".collapseExample3 .icon-bi").className = 'icon-bi bi-plus-lg';
    })
    myCollapsible3.addEventListener('show.bs.collapse', event => {
        document.querySelector(".collapseExample3 .icon-bi").className = 'icon-bi bi-dash-lg';
    })
}

