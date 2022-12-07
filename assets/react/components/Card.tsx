import React, {ReactNode, useEffect, useRef, useState} from 'react';
import Fade from "./Fade";
import * as rank from "../../image/Rank_set1/Rank_High/rank_high_18.png";
import * as mockupPC from "../../image/mockup-pc.png";

type CardProps = {
    heading: string,
    children: ReactNode
}

const Card = ({heading, children,}: CardProps) => {
    const cardRef = useRef();
    const [isVisible, setIsVisible] = useState(false);
    const ratio = 0.05;

    const callbackFunction = (entries: any[], observer: { unobserve: (arg0: never) => void; }) => {
        entries.forEach(entry => {
            if (cardRef.current && (entry.intersectionRatio > ratio)) {
                console.log("hello")
                setIsVisible(true)
                observer.unobserve(cardRef.current)
            }
        })
    }

    let options: { root: null; rootMargin: string; threshold: number };
    options = {
        root: null,
        rootMargin: "0px",
        threshold: 1.0
    };

    useEffect(() => {
        const observer = new IntersectionObserver(callbackFunction, options)
        if (cardRef.current) observer.observe(cardRef.current)
    }, [cardRef, options])

    return (
        <Fade
            visible={isVisible}
            duration={300}

        >
            <div
                className="badge-card"
                ref={cardRef}
            >
                <div className="card">
                    <div className="feature-overview">
                        <div className="template">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div className="badge-detail">
                        <h3>{heading}</h3>
                        <div>
                            <img src={rank} alt=""/>
                        </div>
                    </div>
                </div>
                {children}
            </div>
        </Fade>
    );
}

export default Card;