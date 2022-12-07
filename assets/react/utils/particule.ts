class Particule {
    private size: number;
    private directionX: number;
    private x: number;
    private y: number;
    private color: string;
    private directionY: number;
    constructor() {
        this.size = (Math.random() * 15) + 1;
        this.x = (Math.random() * ((innerWidth - this.size * 2) - (this.size * 2)) + this.size * 2);
        this.y = (Math.random() * ((innerHeight - this.size * 2) - (this.size * 2)) + this.size * 2);
        this.directionX = (Math.random() * 5) - 2.5
        this.directionY = (Math.random() * 5) - 2.5
        this.color = this.getRandColor();
    }

    getRandColor() {
        const green = "hsla(114, 87%, 41%, 0.4)";
        const black = "rgba(0, 0, 0, 0.4)";
        const red = "rgba(255, 0, 0, 0.4)";
        const randNumber = Math.floor(Math.random() * 3)
        switch (randNumber) {
            case 0 :
                return green;
            case 1 :
                return black;
            case 2 :
                return red;
            default:
                break;
        }
    }

    draw(context: { beginPath: () => void; arc: (arg0: number, arg1: number, arg2: number, arg3: number, arg4: number, arg5: boolean) => void; fillStyle: string; fill: () => void }, canvas: any) {
        context.beginPath();
        context.arc(this.x, this.y, this.size, 0, Math.PI * 2, false)
        context.fillStyle = this.color
        context.fill()
    }

    update(context: { beginPath: () => void; arc: (arg0: number, arg1: number, arg2: number, arg3: number, arg4: number, arg5: boolean) => void; fillStyle: string; fill: () => void; }, canvas: any) {
        // if (this.x > canvas.width || this.x < 0) {
        //     this.directionX = -this.directionX;
        // }
        // if (this.y > canvas.height || this.y < 0) {
        //     this.directionY = -this.directionY;
        //
        // }
        // this.x += (this.directionX);
        // this.y += this.directionY;
        this.draw(context, canvas)
    }
}

export default Particule