<?php

namespace Tests\Feature;

use Tests\TestCase;

class FeedTest extends TestCase
{
    public function test_success_response_is_returned_with_valid_xml_format(): void
    {
        $response1 = $this->get(route('api.v1.feeds.index', ['movie']));
        $response2 = $this->get(route('api.v1.feeds.index', ['politics']));
        $response3 = $this->get(route('api.v1.feeds.index', ['lifeandstyle']));
        $response4 = $this->get(route('api.v1.feeds.index', ['art-craft']));
        $response5 = $this->get(route('api.v1.feeds.index', ['art-craft-art']));

        $response1->assertStatus(200);
        $response2->assertStatus(200);
        $response3->assertStatus(200);
        $response4->assertStatus(200);
        $response5->assertStatus(200);

        $dom = new \DOMDocument;

        $this->assertTrue($dom->loadXML($response1->getContent()));
        $this->assertTrue($dom->loadXML($response2->getContent()));
        $this->assertTrue($dom->loadXML($response3->getContent()));
        $this->assertTrue($dom->loadXML($response4->getContent()));
        $this->assertTrue($dom->loadXML($response5->getContent()));
    }

    public function test_error_response_is_returned_with_invalid_input_containing_valid_xml_format(): void
    {
        $response1 = $this->get(route('api.v1.feeds.index', ['Movie']));
        $response2 = $this->get(route('api.v1.feeds.index', ['MOVIE']));
        $response3 = $this->get(route('api.v1.feeds.index', ['mo1vie']));
        $response4 = $this->get(route('api.v1.feeds.index', ['123']));

        $response1->assertStatus(422);
        $response2->assertStatus(422);
        $response3->assertStatus(422);
        $response4->assertStatus(422);

        $dom = new \DOMDocument;

        $this->assertTrue($dom->loadXML($response1->getContent()));
        $this->assertTrue($dom->loadXML($response2->getContent()));
        $this->assertTrue($dom->loadXML($response3->getContent()));
        $this->assertTrue($dom->loadXML($response4->getContent()));
    }
}
