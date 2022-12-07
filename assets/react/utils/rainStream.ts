export const validChars = `abcdefghijklmnopqrstuvwxyz0123456789$+-*/=%"'#&_(),.;:?!\\|{}<>[]^~`;

const streamMutationOdd = 0.02

export const minStream = 5;
export const maxStream = 30;

export const minIntervalDelay = 50;
export const maxIntervalDelay = 100;

export const minDelayBeetwenStreams = 0;
export const maxDelayBeetwenStreams = 15;

export const getRandomChar = () => validChars.charAt(Math.floor(Math.random() * validChars.length));

export const getRandomRange = (min: number, max: number) => Math.floor(Math.random() * (max - min) + min)

export const getRandomStream = () =>
    new Array(getRandomRange(minStream, maxStream))
        .fill(undefined, undefined, undefined)
        .map(() => getRandomChar())

export const getMutatedStream = (stream: any[]) => {
    const newStream = [];
    for (let i = 1; i < stream.length; i++) {
        if (Math.random() < streamMutationOdd) {
            newStream.push(getRandomChar());
        } else {
            newStream.push(stream[i]);
        }
    }
    newStream.push(getRandomChar());
    return newStream;
};

