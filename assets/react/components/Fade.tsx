import './fade.scss';
import React, {FunctionComponent, ReactNode} from 'react';

type Props = {
    visible: boolean,
    children: ReactNode,
    duration: number,
    translateValue?: number
}

const Fade: FunctionComponent<Props> = ({visible, children, duration = 300, translateValue = -200}) => {
    let style: { transform: null | string; transitionProperty: string; transitionDuration: string; opacity: null | number } = {
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