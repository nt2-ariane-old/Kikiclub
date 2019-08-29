const onPageLoad = () =>
{
    
    let toCopy  = document.getElementById( 'link' ),
        btnCopy = document.getElementById( 'copy' );
    
        btnCopy.onclick = () => {
        toCopy.focus();
        toCopy.select();
        document.execCommand( 'copy' );
        return false;
    }
}