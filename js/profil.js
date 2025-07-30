if (document.getElementById("aside")) {
    const node_env = "dev";
    const href = window.location;
    const url = new URL(href);
    const pathname = url.pathname;
    console.log("pathname",url);
    if(node_env === 'dev'){
        const seg = pathname.split("/")[3];
        const links = $(".profilNav li");
        //console.log("seg",seg);
        links.each(function(index){
            if(seg === '' && index == 0){
                links.find('a').removeClass("active")
                $(this).find('a').addClass('active');
            }else if(seg === 'booking' && index === 1){
                links.find('a').removeClass("active")
                $(this).find('a').addClass('active');
            }else if(seg === 'security' && index === 2){
                links.find('a').removeClass("active")
                $(this).find('a').addClass('active');
            }
        })
    }
}