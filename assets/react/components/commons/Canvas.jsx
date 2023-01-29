import React, {useEffect, useRef, useState} from 'react';
import Particule from "../utils/particule";


const Canvas = (props) => {
    const canvasRef = useRef(null)
    const [context, setContext] = useState(null)
    const [particules, setParticules] = useState([])

    useEffect(() => {
        const canvas = canvasRef.current
        const ctx = canvas.getContext("2d");
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        setContext(ctx)

    }, [canvasRef])

    useEffect(() => {
        if (context) {
            init()
        }
    }, [context]);

    useEffect(() => {
        if (context) {
            animate()
        }
    }, [particules]);

    const init = () => {
        const particulesArray = [];
        const numberOfParticules = (canvasRef.current.height * canvasRef.current.width) / 40000
        for (let i = 0; i < numberOfParticules; i++) {
            particulesArray.push(new Particule())
        }
        setParticules(particulesArray)
    }

    const animate = () => {
        requestAnimationFrame(animate)
        context.clearRect(0, 0, innerWidth, innerHeight)

        particules.forEach((particule) => {
            console.log(particule)
            particule.update(context, canvasRef.current)
        })
    }


    return (
        <canvas
            ref={canvasRef}
            style={{
                position: "fixed",
                top: 0,
                left: 0,
                display: "block",
                width: "100%",
                height: "100%",
                zIndex: 0,
            }}
            {...props}
        />


    );
}

export default Canvas;