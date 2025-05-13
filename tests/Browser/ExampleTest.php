<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     */
    public function testBasicExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    // Just check that the page loads without a server error
                    ->assertDontSee('Server Error')
                    ->assertDontSee('Whoops, something went wrong')
                    ->screenshot('homepage');
        });
    }
}
