import React, {useEffect, useRef, useState} from 'react';
import useInterval from '@use-it/interval';
import {
    getMutatedStream,
    getRandomRange,
    getRandomStream, maxDelayBeetwenStreams,
    maxIntervalDelay, minDelayBeetwenStreams,
    minIntervalDelay
} from "../../utils/rainStream";



const RainStream = ({height}) => {
    const [stream, setStream] = useState([]);
    const [intervalDelay, setIntervalDelay] = useState(null);
    const [paddingTop, setPaddingTop] = useState(stream.length * -70);

    useEffect(() => {
        setTimeout(() => {
            setIntervalDelay(getRandomRange(minIntervalDelay, maxIntervalDelay));
        }, getRandomRange(minDelayBeetwenStreams, maxDelayBeetwenStreams));
    }, []);

    useInterval(() => {
        if (!height) return;

        if (!intervalDelay) return;

        if (paddingTop > height) {
            setStream([]);
            const newStream = getRandomStream();
            setStream(newStream);
            setPaddingTop(newStream.length * -50);
            setIntervalDelay(null);
            setTimeout(
                () =>
                    setIntervalDelay(
                        getRandomRange(minIntervalDelay, maxIntervalDelay),
                    ),
                getRandomRange(minDelayBeetwenStreams, maxDelayBeetwenStreams),
            );
        } else {
            setPaddingTop(paddingTop + 15);
        }
        setStream(getMutatedStream);
    }, intervalDelay);

    return (
        <div
            style={{
                marginTop: paddingTop,
                color: "#20c20e",
                writingMode: "vertical-rl",
                textOrientation: "upright",
                whiteSpace: "nowrap",
                userSelect: "none",
                textShadow: "0px 0px 8px rgba(32, 194, 14, 0.8",
                fontSize: 16,
                fontFamily: 'Poor Story',
            }}
        >
            {stream && stream.map((char, index) =>
                <a
                    style={{
                        color: index === stream.length - 1 ? "#fff" : undefined,
                        opacity: index < 6 ? 0.1 + index * 0.15 : 1,
                        textShadow: index === stream.length - 1 ?
                            "0px 0px 20px rgba(255, 255, 255, 1)"
                            :
                            undefined,
                    }}
                    key={index}
                >
                    {char}
                </a>
            )}

        </div>
    );
}

export default RainStream;