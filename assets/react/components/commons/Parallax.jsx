import React, {useEffect} from 'react';

const Parallax = ({element, ratio, children}) => {


    const offSetTop = (element, acc = 0) => {
        if (!element.offsetParent) {
            return offSetTop(element.offsetParent, acc + element.offsetTop)
        }
        return acc + element.offsetTop
    }

    const onScroll = (element) => {
        const screenY = window.scrollY + window.innerHeight / 2
        const elementY = offSetTop(element) + element.offsetHeight / 2
        const diffY = elementY - screenY
        element.style.setProperty("transform", `translateY(${diffY * -1 * ratio}px)`)
    }
    useEffect(() => {
        ratio = parseFloat(ratio);
        document.addEventListener('scroll', () => onScroll(element.current))
    }, [])
    return (
        <>
            {children}
        </>
    )
}

export default Parallax;