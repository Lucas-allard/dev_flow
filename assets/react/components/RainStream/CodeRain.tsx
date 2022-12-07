import React, {useEffect, useRef, useState} from 'react';
import RainStream from "./RainStream";

const CodeRain = () => {
    const containerRef = useRef(null);
    const [containerSize, setContainerSize] = useState(null);

    useEffect(() => {
        const boundingClientRect = containerRef.current.getBoundingClientRect();
        setContainerSize({
            width: boundingClientRect.width,
            height: boundingClientRect.height,
        });
    }, []);


    const streamCount = containerSize ? Math.floor(containerSize.width / 14) : 0;
    // @ts-ignore
    // @ts-ignore
    // @ts-ignore
    return (
        <div
            style={{
                position: "absolute",
                top: 0,
                right: 0,
                bottom: 0,
                left: 0,
                backgroundColor: "#121212",
                padding: "300px 0",
                overflow: 'hidden',
                display: 'flex',
                flexDirection: 'row',
                justifyContent: 'center',
                zIndex: 1
            }}
            ref={containerRef}
        >
            {new Array(streamCount).fill(undefined, undefined,undefined).map((stream, index) => (
                <RainStream
                    height={containerSize?.height}
                    key={index}
                />
            ))}
        </div>
    );
}

export default CodeRain;