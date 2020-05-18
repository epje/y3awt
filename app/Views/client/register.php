<?php
$session = Config\Services::session();
helper('form');
$message = $session->getFlashdata('message');
$error = $session->getFlashdata('error');

$titleOptions = [
    'mr' => 'Mr.',
    'mrs' => 'Mrs.',
    'miss' => 'Miss.',
    'dr' => 'Dr.'
];

?>
<style>
    .card-register {
        border-radius: 1rem;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-md-6 col-lg-5 mx-auto">
            <div class="card shadow-sm card-register my-5">
                <div class="card-body">
                    <h2 class="card-title text-center"><?= getenv('app.name'); ?></h2>
                    <h5 class="card-subtitle text-center font-weight-light">Register</h5>
                    <div id="root"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>

<script type="text/babel">
    class NameForm extends React.Component {
        constructor(props) {
            super(props);
            this.state = {firstName: ''};
            //this.state = {value: 'Write your Name'};

            this.handleFirstName = this.handleFirstName.bind(this);
            this.handleLastName = this.handleLastName.bind(this);
            this.handleTitle =
            // this.handleSubmit = this.handleSubmit.bind(this);
        }

        //TODO

        handleFirstName(event) {
            this.setState({firstName: event.target.value});
            //this.setState({value: event.target.value.toLowerCase()});
            var textval = this.state.firstName;
            //user validation of the special characters
            var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";
            for (var i = 0; i < textval.length; i++) {
                if (iChars.indexOf(textval.charAt(i)) != -1) {
                    alert("Your username should not have !@#$%^&*()+=-[]\\\';,./{}|\":<>? \nThese are not allowed.\n Please remove them and try again.");
                    //return false;
                }
            }
        }

        handleLastName(event) {
            this.setState({})
        }

        // handleLastName(event) {
        //     this.setState({value2: event.target.value});
        //     var textval = this.state.value2;
        //     //user validation of the special characters
        //     if (isNaN(textval))
        //         alert(textval);
        // }

//without .preventDefault() the submitted form would be refreshed
//         handleSubmit(event) {
//             alert('The submitted name is: ' + this.state.value + ', Also Phone: ' + this.state.value2);
//             event.preventDefault();
//         }

        render() {
            return (
                //TODO: do label for=...
                <form onSubmit={this.handleSubmit}>
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" value={this.state.firstName} onChange={this.handleFirstName}  name="first_name"
                               id="firstName" class="form-control"
                               placeholder="Joe"/>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="" class="form-control"
                               placeholder="Bloggs"/>
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" value="" class="form-control"
                               placeholder="Mr."/>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="" class="form-control"
                               placeholder="01234567890"/>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="text" name="email" value="" class="form-control"
                               placeholder="joe.bloggs&#x40;example.com"/>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" value="" class="form-control"
                               placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_conf" value=""
                               class="form-control&#x20;invalid"
                               placeholder="Confirm&#x20;Password"/>
                    </div>
                    <input type="submit" name="submit" value="Register Account" class="btn btn-block btn-primary"/>

                </form>
            );
        }
    }

    ReactDOM.render(
        <NameForm/>,
        document.getElementById('root')
    );


</script>