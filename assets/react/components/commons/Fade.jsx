import './fade.scss';
import React from 'react';



const Fade = ({visible, children, duration = 300, translateValue = -200}) => {
    let style = {
        transitionDuration: `${duration}ms`,
        transitionProperty: "opacity transform",
        opacity: null,
        transform: null
    }

    if (!visible) {
        style.opacity = 0;
        style.transform = `translateX(${translateValue}px)`
    }

    return (
        <div style={style}>{children}</div>
    )

}

export default Fade;