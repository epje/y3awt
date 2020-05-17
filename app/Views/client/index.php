<?php
helper('session');

?>

<script src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>

<div>
    <div class="row">
        <div class="col">
            <div>
                <h1>Welcome, <?= session('clientID'); ?></h1>
            </div>
        </div>
    </div>
</div>
<div id="root"></div>

<script type="text/babel">

    class NameForm extends React.Component {
        constructor(props) {
            super(props);
            this.state = {value: ''};
            //this.state = {value: 'Write your Name'};

            this.handleChange = this.handleChange.bind(this);
            this.handleChange2 = this.handleChange2.bind(this);
            this.handleSubmit = this.handleSubmit.bind(this);
        }

        handleChange(event) {
            this.setState({value: event.target.value});
            //this.setState({value: event.target.value.toLowerCase()});
            var textval = this.state.value;
            //user validation of the special characters
            var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";
            for (var i = 0; i < textval.length; i++) {
                if (iChars.indexOf(textval.charAt(i)) != -1) {
                    alert("Your username should not have !@#$%^&*()+=-[]\\\';,./{}|\":<>? \nThese are not allowed.\n Please remove them and try again.");
                    //return false;
                }
            }
        }

        handleChange2(event) {
            this.setState({value2: event.target.value});
            var textval = this.state.value2;
            //user validation of the special characters
            if (isNaN(textval))
                alert(textval);
        }

//without .preventDefault() the submitted form would be refreshed
        handleSubmit(event) {
            alert('The submitted name is: ' + this.state.value + ', Also Phone: ' + this.state.value2);
            event.preventDefault();
        }

        render() {
            return (
                <form onSubmit={this.handleSubmit}>
                    <label>
                        Name:
                        <input type="text" value={this.state.value} onChange={this.handleChange}/>
                        Phone:
                        <input type="text" value={this.state.value2} onChange={this.handleChange2}/>
                    </label>
                    <input type="submit" value="Submit"/>
                </form>
            );
        }
    }

    ReactDOM.render(
        <NameForm/>,
        document.getElementById('root')
    );


</script>

</body>
</html>