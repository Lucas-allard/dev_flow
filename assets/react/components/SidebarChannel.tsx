import React, {FunctionComponent} from 'react';

type Props = {
    channel: string
}

const SidebarChannel: FunctionComponent<Props> = ({channel}) => {
    return (
        <div className="sidebarChannel">
            <h4>
                <span className="sidebarChannel__hash">#</span>
            </h4>
        </div>
    );
}

export default SidebarChannel;